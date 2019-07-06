<?php
/**
 * v1-specific Restful SignupForm model
 */

namespace api\modules\v1\models;


use common\models\BaseModel;

class SignupForm extends \api\common\models\SignupForm
{
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
            ['email', 'email',],
            ['password', 'required',
                'message' => \Yii::t('app', 'Please enter your password.')
            ],
            ['password', 'string', 'min' => 6],
            ['roleId', 'required',
                'message' => \Yii::t('app', 'Please select role.')
            ],
            ['confirm', 'default',
                'value' => null,
            ],
            ['isAccepted', 'default',
                'value' => false,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function signup()
    {
        $user = parent::signup();
        if ($user) {
            $user->active = true;
            $user->save();
        }
        return $user;
    }
}