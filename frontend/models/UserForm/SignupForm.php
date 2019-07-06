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
class SignupForm extends Model
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

    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $confirm;
    public $roleId;
    public $isAccepted;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName'], 'filter', 'filter' => 'trim'],
            ['email', 'required', 
                'message' => \Yii::t('app', 'Please enter your email address.')
            ],
            ['firstName', 'required', 
                'message' => \Yii::t('app', 'Please enter your First Name.')
            ],
            ['lastName', 'required', 
                'message' => \Yii::t('app', 'Please enter your Last Name.')
            ],
            ['email', 'unique', 
                'targetClass' => '\common\models\User', 
                'message' => 'This email has already been taken.'
            ],
            ['email', 'email'],
            ['password', 'required', 
                'message' => \Yii::t('app', 'Please enter your password.')
            ],
            ['password', 'string', 'min' => 6],
            ['roleId', 'required', 
                'message' => \Yii::t('app', 'Please select role.')
            ],
            ['confirm', 'required', 
                'message' => \Yii::t('app', 'Please enter your Confirm.')
            ],
            ['confirm', 'compare', 
                'compareAttribute' => 'password', 
                'message' => \Yii::t('app', 'Passwords doesn\'t match.')
            ],
            ['isAccepted', 'required', 
                'message' => \Yii::t('app', 'Is didn\'t Accept the Terms & Conditions')
            ]
        ];
    }

    /**
     * Get roles for signup
     * 
     * @return array
     */
    public function getRoleArrayMap()
    {
        $roles = Role::find()->all();
        $result = [];
        foreach ($roles as $role) {
            if (!in_array($role->name, $this->_rolesAvailable)) {
                continue;
            }
            $result[$role->id] = \Yii::t('app', $role->title);
        }
        return $result;
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->firstName = $this->firstName;
            $user->lastName = $this->lastName;
            $user->email = $this->email;
            $user->roleId = $this->roleId;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateAccessToken();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
