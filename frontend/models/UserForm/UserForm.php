<?php

namespace frontend\models\UserForm;

use common\models\Image;
use common\models\User;
use yii\web\UploadedFile;

/**
 * User form
 */
class UserForm extends AbstractForm
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $confirm;
    public $id;
    public $imageFile;
    public $image;
    public $roleId;
    public $isBlocked;

    public $block_or_unit;
    public $street_number;
    public $route;
    public $locality;
    public $administrative_area_level_1;
    public $postal_code;
    public $country;
    public $latitude;
    public $longitude;
    public $googleplaceid;
    public $formatted_address;

    /** for backward-compatibility **/
    public $lat;
    public $lng;
    public $placeid;
    
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
            ['password', 'string', 'min' => 6],
            ['password', 'validateСompareConfirm'],
            [['id', 'roleId'], 'integer'],
            ['email', 'validateUniqueEmail'],
            ['confirm', 'string'],
            [['imageFile', 'image'], 'safe'],
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif'],
            [['isBlocked'], 'boolean'],
            [['block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code',
                'country', 'latitude', 'longitude', 'googleplaceid', 'lat', 'lng', 'placeid', 'formatted_address'], 'safe'], // safe for now
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function setData($user)
    {
        $this->setAttributes($user->getAttributes());
        $this->image = $user->image;
    }
    
    /**
     * Save
     */
    public function save()
    {
        $user = User::findOne($this->id);
        if (!$user) {
            $user = new User();
        }
        $user->setAttributes($this->getAttributes());
        if ($this->password) {
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $this->password = null;
            $this->confirm = null;
        }
        $image = new Image();
        $image->save();
        $image->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($image->imageFile) {
            $image->saveFiles();
            $image->save();
            $user->imageId = $image->id;
        }
        $user->isBlocked = $this->isBlocked;
        $user->save();
        $this->image = $user->image;
    }
    
    /**
     * Get template
     * 
     * @return string
     */
    public function getTemplate()
    {
        return 'user';
    }
}
