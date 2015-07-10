<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 11:00
 */

namespace frontend\models\UserForm;


use common\models\Image;
use common\models\Role;
use common\models\User;
use frontend\models\Exception\FranchiserUndefinedException;
use Yii;
use yii\web\UploadedFile;

class FranchiserManagerAddForm extends AbstractForm
{

    protected $_roleNames = [Role::ROLE_FRANCHISER_MANAGER];

    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $id;
    public $imageFile;
    public $image;
    public $roleId;
    public $isAdmin;

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
        ];
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
            $user->parentId = $this->getFranchiserId($currentUser);
        }
        $user->setAttributes($this->getAttributes());
        if ($this->canToBeExtendedFranchiserManager()) {
            $role = Role::findOne(['name' => Role::ROLE_FRANCHISER_MANAGER_EXTENDED]);
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

    public function isManager()
    {
        $roleFrManager = Role::findOne(['name' => Role::ROLE_FRANCHISER_MANAGER]);
        return $this->roleId == $roleFrManager->id;
    }

    /**
     * @return bool
     */
    private function canToBeExtendedFranchiserManager()
    {
        return $this->isAdmin && $this->isManager();
    }

    /**
     * @param User $currentUser
     * @return int|null
     */
    private function getFranchiserId(User $currentUser)
    {
        if ($currentUser->franchiser) {
            return $currentUser->id;
        }

        if ($currentUser->parentUser && $currentUser->parentUser->franchiser) {
            return $currentUser->parentUser->id;
        }

        throw new FranchiserUndefinedException($currentUser);
    }

    /**
     * @return bool
     */
    public function canToSeeIsAdminCheckBox()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        return in_array($user->role->name, [
            Role::ROLE_FRANCHISER,
            Role::ROLE_FRANCHISER_MANAGER_EXTENDED
        ]);
    }

    /**
     * Get roles array map
     */
    public function getRoleArrayMap()
    {
        $result = [];
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
}