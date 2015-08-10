<?php

namespace frontend\models\UserForm;

use app\models\UserForm\StoresAwareTrait;
use common\models\Image;
use common\models\Role;
use common\models\User;
use frontend\models\Exception\UserStoreOwnerUndefinedException;
use Yii;
use yii\web\UploadedFile;

/**
 * User form
 */
class UserAddForm extends AbstractForm
{

    use StoresAwareTrait;

    protected $_roleNames = [Role::ROLE_EMPLOYEE, Role::ROLE_MANAGER];

    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $id;
    public $imageFile;
    public $image;
    public $roleId;
    public $isAdmin;
    public $storeslist;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName'], 'filter', 'filter' => 'trim'],
            [['email', 'password'], 'required',
                'message' => \Yii::t('app', 'Please enter your email address.')
            ],
            ['firstName', 'required',
                'message' => \Yii::t('app', 'Please enter your First Name.')
            ],
            ['lastName', 'required',
                'message' => \Yii::t('app', 'Please enter your Last Name.')
            ],
            ['password', 'string', 'min' => 6],
            [['id', 'roleId'], 'integer'],
            [['isAdmin'], 'boolean'],
            ['email', 'validateUniqueEmail'],
            [['imageFile', 'image'], 'safe'],
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif'],
            ['storeslist', 'safe']
        ];
    }

    /**
     * Is manager?
     *
     * @return bool
     */
    public function isManager()
    {
        $role = Role::findOne(['name' => Role::ROLE_MANAGER]);
        return $this->roleId == $role->id;
    }

    /**
     * Get roles array map
     */
    public function getRoleArrayMap()
    {
        $roles = Role::find()
            ->select(['id', 'title'])
            ->andWhere(['name' => $this->_roleNames])
            ->asArray()
            ->all();
        foreach ($roles as $item) {
            $result[$item['id']] = $item['title'];
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function setData($user)
    {
        $this->setAttributes($user->getAttributes());
        if ($user->role->name == Role::ROLE_YELLO_ADMIN) {
            $this->isAdmin = true;
            $role = Role::findOne(['name' => Role::ROLE_MANAGER]);
            $this->roleId = $role->id;
            $this->storeslist = $this->getStoresArrayMap();
        }
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
            /** @var User $currentUser */
            $currentUser = Yii::$app->user->identity;
            $user->parentId = $this->getStoreOwnerId($currentUser);
        }
        $user->setAttributes($this->getAttributes());
        $role = Role::findOne(['name' => Role::ROLE_EMPLOYEE]);
        $user->roleId =  $role->id;
        if ($this->isAdmin && $this->isManager()) {
            $role = Role::findOne(['name' => Role::ROLE_MANAGER]);
            $user->roleId = $role->id;
        }
        if ($this->password) {
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $this->password = null;
        }
        $image = new Image();
        $image->save();
        $image->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($image->imageFile) {
            $image->saveFiles();
            $image->save();
            $user->imageId = $image->id;
        }

        $user->generateAccessToken();
        $user->active = true;
        $user->save();
        $this->image = $user->image;
        $this->stores=$this->storeslist;
        $this->saveUserStoreRelations($user);
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'userCreate';
    }

    private function getStoreOwnerId(User $user)
    {
        if ($user->storeOwner) {
            return $user->id;
        } else {
            if ($user->parentUser && $user->parentUser->storeOwner) {
                return $user->parentUser->id;
            }
        }

        throw new UserStoreOwnerUndefinedException($user);
    }
}
