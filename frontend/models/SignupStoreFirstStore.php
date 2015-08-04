<?php
namespace frontend\models;

use common\models\User;
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
    public $businesstype;
    
    public $block_or_unit;
    public $street_number;
    public $route;
    public $locality;
    public $administrative_area_level_1;
    public $postal_code;
    public $country;
    public $formatted_address;


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
                    'id', 'title', 'businessTypeId',
                    'businessHours', 'storeProfile', 'image', 'imageFile'
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
        
    public function getBusinessTypeArrayMap()
    {
        $businessTypes = BusinessType::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();
        $result = [
            null => \Yii::t('app', 'Select business type')
        ];
        foreach ($businessTypes as $item) {
            $result[$item['id']] = $item['title'];
        }
        return $result;
    }

    /**
     * @param User $user
     * @return \common\models\StoreOwner
     * @throws UserStoreOwnerUndefinedException
     */
    private function getUserStoreOwner(User $user)
    {
        if ($user->storeOwner) {
            return $user->storeOwner;
        }

        if ($user->parentUser && $user->parentUser->storeOwner) {
            return $user->parentUser->storeOwner;
        }

        throw new UserStoreOwnerUndefinedException($user, 'Cannot detect storeOwner');
    }
    
    
    
}
