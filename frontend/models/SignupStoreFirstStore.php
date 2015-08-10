<?php
namespace frontend\models;

use common\models\Address;
use common\models\Store;
use common\models\StoreAddress;
use common\models\StoreOwner;
use common\models\User;
use common\models\UserHasStore;
use yii\base\Model;
use Yii;
use common\models\Role;

/**
 * Signup form
 *
 * @property array $roles Roles allowed to register
 */
class SignupStoreFirstStore extends Model
{
    /**
     * Roles that are allowed to be registered with current model
     *
     * @var array
     */
    protected $_rolesAvailable = [
        Role::ROLE_STORE_OWNER
    ];

    public $storename;
    public $businessTypeId;
    public $companyId;
//    public $storeOwnerId;

    public $block_or_unit;
    public $street_number;
    public $route;
    public $locality;
    public $administrative_area_level_1;
    public $postal_code;
    public $country;
    public $formatted_address;
    public $googleplaceid;
    public $googleobj;


    // company address
    public $contact_email;
    public $contact_phone;
    public $contact_name;    
    public $website;
    
    public $businessHours;
    public $storeProfile;
    public $image;
    public $imageFile;
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'businessTypeId',
                    'businessHours', 'storeProfile', 'image', 'imageFile'
                ],
                'safe'
            ],

            [
                [
                    'block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1',
                    'postal_code', 'country', 'formatted_address', 'googleplaceid', 'googleobj',
                ],
                'safe'
            ],

            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif']
        ];
    }


    public function attributeLabels()
    {
        $labels = [
            'administrative_area_level_1'=>'State',
            'postal_code'=>'Postcode',
            'route'=>'',
            'street_number'=>'',
            'block_or_unit'=>'',
            'locality'=>'Suburb'
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * Save data from step-one
     *
     * @param \common\models\User $user
     *
     * @return boolean
     */
    public function save($user)
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $storeOwner = new StoreOwner([
                'companyId' => $this->companyId,
                'userId' => $user->id,
            ]);
            if (!$storeOwner->save()) {
                $error = $storeOwner->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $address = new Address();
            $address->setAttributes($this->getAttributes());
            if (!$address->save()) {
                $error = $address->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $store = new Store();
            $store->setAttributes($this->getAttributes());
            $store->storeOwnerId = $storeOwner->id;
            if (!$store->save()) {
                $error = $store->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $storeAddress = new StoreAddress([
                'storefk' => $store->id,
                'addressfk' => $address->idaddress,
            ]);
            if (!$storeAddress->save()) {
                $error = $storeAddress->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $userHasStore = new UserHasStore([
                'userId' => $user->id,
                'storeId' => $store->id
            ]);
            if (!$userHasStore->save()) {
                $error = $userHasStore->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $user->signup_step_completed = 3;
            $user->save(false);

            $transaction->commit();

            return true;

        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }
}
