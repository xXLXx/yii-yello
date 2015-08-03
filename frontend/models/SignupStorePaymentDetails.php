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
class SignupStorePaymentDetails extends Model
{
    /**
     * Roles that are allowed to be registered with current model
     *
     * @var array
     */
    protected $_rolesAvailable = [
        Role::ROLE_FRANCHISER,
        Role::ROLE_MENU_AGGREGATOR,
        Role::ROLE_STORE_OWNER
    ];

    public $cardholdername;
    public $address_line1;
    public $address_line2;
    public $address_city;
    public $address_state;
    public $address_zip;
    public $address_country;
    public $formatted_address;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cardholdername'], 'filter', 'filter' => 'trim'],
            ['cardholdername', 'required', 
                'message' => \Yii::t('app', 'Please enter the name appearing on the card.')
            ],
        ];
    }

    public function attributeLabels()
    {
        $labels = [
            'address_line1' => 'Address (Line 1)',
            'address_line2' => 'Address (Line 2)',
            'address_city'=>\Yii::t('app', 'Suburb'),
            'address_state'=> \Yii::t('app', 'State'),
            'address_zip'=> \Yii::t('app', 'Postcode'),
            'address_country'=> \Yii::t('app', 'Country')
            
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }    
        
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
                return true;
            }

        return false;
    }
}
