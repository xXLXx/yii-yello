<?php
namespace frontend\models;

use common\models\Address;
use common\models\Store;
use common\models\StoreAddress;
use common\models\StoreOwner;
use common\models\User;
use common\models\Image;
use yii\web\UploadedFile;
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
    public $latitude;
    public $longitude;


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
                    'latitude', 'longitude',
                ],
                'safe'
            ],

            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif']

            ,['storename', 'required', 
                'message' => \Yii::t('app', 'Please enter store name.')
            ]

            
            ,['businessTypeId', 'required', 
                'message' => \Yii::t('app', 'Please choose a business type.')
            ]

            
            ,['contact_name', 'required', 
                'message' => \Yii::t('app', 'Please enter a contact name.')
            ]

            
            ,['contact_phone', 'required', 
                'message' => \Yii::t('app', 'Please enter contact phone number.')
            ]

            
            ,['contact_email', 'required', 
                'message' => \Yii::t('app', 'Please enter a contact email.')
            ]

            ,['contact_email', 'email', 
                'message' => \Yii::t('app', 'Please enter a valid email address.')
            ]

            
            
            
        ];
    }


    public function attributeLabels()
    {
        $labels = [
            'businessTypeId' => 'Business Type',
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
            
            $updateimageid=false;
            $image = new Image();
            $image->imageFile = UploadedFile::getInstance($this, 'imageFile');
            if ($image->imageFile) {
                if (!$image->saveFiles()) {
                    $error = $image->getFirstError();
                    $this->addError(key($error), current($error));

                    throw new \yii\db\Exception(current($error));
                }
                $image->save();
                $updateimageid=true;
            }
            
            $storeOwner = $user->storeOwner;
            if(!$storeOwner){
            $storeOwner = new StoreOwner([
                'companyId' => $this->$user->company->id,
                'userId' => $user->id,
            ]);            }
            $storeOwner->companyId=$user->company->id;
                


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
            $store->title=$this->storename;
            if (!$store->save()) {
                $error = $store->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $storeAddress = new StoreAddress([
                'storefk' => $store->id,
                'addressfk' => $address->idaddress,
                'contact_name'=>$this->contact_name,
                'contact_email'=>$this->contact_email,
                'contact_phone'=> $this->contact_phone,
                'addresstitle'=>'Default',
                'addresstype'=>1
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
            if($updateimageid){
                $store->imageId=$image->id;
            }
            $store->save();
            \Yii::$app->session->set('currentStoreId', $store->id);

            $transaction->commit();

            return true;

        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }
}
