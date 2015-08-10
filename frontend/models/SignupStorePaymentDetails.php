<?php
namespace frontend\models;

use common\models\Company;
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
        Role::ROLE_STORE_OWNER
    ];

    public $cardholdername;
    public $stripeId;
    public $companyId;
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
//            [['cardholdername'], 'filter', 'filter' => 'trim'],
//            ['cardholdername', 'required',
//                'message' => \Yii::t('app', 'Please enter the name appearing on the card.')
//            ],
            ['stripeId', 'required'],
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
     * Save payment details data (step-two)
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

        $company = Company::findOne(['id' => $this->companyId]);
        $company->stripeid = $this->stripeId;

        $user->signup_step_completed = 3;
        $user->save(false);

        return $company->save(false);
    }
}
