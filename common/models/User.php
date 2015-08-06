<?php
namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;
use frontend\models\CompanyForm;
use common\models\query\UserQuery;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $accessToken
 * @property string $email
 * @property string $authKey
 * @property string $passwordHash
 * @property string $passwordResetToken
 * @property string $password write-only password
 * @property Boolean $active active?
 * @property string $firstName first name
 * @property string $lastName last name
 * @property integer $imageId imageId
 * @property Boolean $hasExtendedRights has extended rights
 * @property Boolean $isBlocked is user blocked
 * @property integer $signup_step_completed
 * @property User $parentUser parent user
 * 
 * @property StoreOwner $storeOwner store Owner
 * @property Company $company company
 * @property Franchiser $franchiser franchiser
 * @property MenuAggregator $menuAggregator Menu aggregator
 *
 * @property Role $role role
 * @property Image $image image
 * @property UserDriver $userDriver userDriver

 * @property UserHasCompany[] $userHasCompanies userHasCompanies

 * @property UserHasStore[] $userHasStores userHasStores
 * @property Store[] $stores stores
 * @property Store $storeCurrent the current selected store
 */
class User extends BaseModel implements IdentityInterface
{

    /**
     * @var array[integer]
     */
    private $tempStores;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge([
            [['firstName', 'lastName', 'email', 'roleId', 'stores'], 'safe']
        ], parent::rules());
    }
    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'image',
            'userDriver',
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'firstName',
            'lastName',
            'imageId',
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * Get role
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'roleId']);
    }

    /**
     * Get Image
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'imageId']);
    }

    
    
    
    
    /**
     * Get userHasStores
     * @return ActiveQuery
     */
    public function getUserHasStores()
    {
        return $this->hasMany(UserHasStore::className(), ['userId' => 'id']);
    }

    /**
     * Get stores
     * @return static
     */
    public function getStores()
    {
        return $this->hasMany(Store::className(), ['id' => 'storeId'])
            ->via('userHasStores');
    }

    /**
     * @param $stores
     */
    public function setStores($stores)
    {
        $this->tempStores = $stores;
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    
    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'passwordResetToken' => $token
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }

    /**
     * Generate and, optionally, save a new Access Token for a mobile apps
     */
    public function generateAccessToken()
    {
        do {
            $accessToken = Yii::$app->security->generateRandomString();
            $user = static::findIdentityByAccessToken($accessToken);
        }
        while (!empty($user));
        $this->accessToken = $accessToken;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->passwordResetToken = null;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert) 
    {
        $this->username = $this->firstName . ' ' . $this->lastName;
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) 
    {
        if ($insert) {
            switch ($this->role->name) {
                case Role::ROLE_STORE_OWNER:
                    $storeOwner = new StoreOwner();
                    $storeOwner->userId = $this->id;
                    $storeOwner->save();
                    break;
                case Role::ROLE_FRANCHISER:
                    $franchiser = new Franchiser();
                    $franchiser->userId = $this->id;
                    $franchiser->save();
                    break;
                case Role::ROLE_MENU_AGGREGATOR:
                    $menuAggregator = new MenuAggregator();
                    $menuAggregator->userId = $this->id;
                    $menuAggregator->save();
                    break;
            }
        }

        if (count($this->tempStores) > 0) {
            UserHasStore::deleteAll(['userId' => $this->id]);
            foreach ($this->tempStores as $store) {
                $relation = new UserHasStore();
                $relation->userId = $this->id;
                $relation->storeId = (int)$store;
                $relation->save();
            }
            $this->tempStores = [];
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Get stores
     *
     * @return Store
     */
    public function getStoreCurrent()
    {
        $storeId = \Yii::$app->session->get('currentStoreId');
        if (!$storeId) {
            $storeOwner = $this->storeOwner;
            if ($storeOwner) {
                $store = $storeOwner->getStores()->one();
            } else {
                $store = $this->getStores()->one();
            }
            if ($store) {
                \Yii::$app->session->set('currentStoreId', $store->id);
            }
        } else {
            $store = Store::findOne($storeId);
        }
        return $store;
    }

    /**
     * Set current store
     *
     * @param int $storeId
     */
    public function setStoreCurrentById($storeId)
    {
        \Yii::$app->session->set('currentStoreId', $storeId);
    }
    
    /**
     * Get storeOwner
     * 
     * @return \yii\db\ActiveRecord 
     */
    public function getStoreOwner()
    {
        return $this->hasOne(StoreOwner::className(), ['userId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFranchiser()
    {
        return $this->hasOne(Franchiser::className(), ['userId' => 'id']);
    }

    /**
     * Get parent user
     *
     * @return ActiveQuery
     */
    public function getParentUser()
    {
        return $this->hasOne(User::className(), ['id' => 'parentId']);
    }
    
    /**
     * Get userDriver
     * 
     * @return \yii\db\ActiveRecord 
     */
    public function getUserDriver()
    {
        return $this->hasOne(UserDriver::className(), ['userId' => 'id']);
    }
    
    /**
     * Get company
     * 
     * @return \yii\db\ActiveRecord 
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['userfk' => 'id', 'isprimary'=>1]);
    }

    /**
     * Get a currently authorized User
     *
     * @return User|null
     */
    public static function getCurrent()
    {
        return static::findOne(['User.id' => \Yii::$app->user->identity->getId()]);
    }

    /**
     * This is referenced by basecontroller at frontend
     * 
     * todo: consider running it only on login and setting a validated flag 
     * Make sure user info is all there
     * This is the post-signon switchboard that verifies all signup info is there
     * and that subscription is valid this function will find the user's role
     * and run appropriate subroutines to verify validation of the users details
     * and organisation details, and subscription details
     * @return $ca|false
     * populate ca with list of [controller, action, selected] that user is allowed
     * to see while signup is incomplete. set selected to true for the preferred
     * controller/action
     */
    public function getSignUpState(){
        $ca=[];   //controller actions
                 // if ca[] is populated and returned, it should have at least
        
        switch ($this->roleId){
            case 1:// yello super admin
            case 8: // yello admin
                // go to settings page
                // TODO: send to admin dashboard
                return false;
                break;
            
            case 2: // Franchiser
            case 10: // franchiserManager
            case 11: // franchiserExtendedManager
                    // make sure franchise info is complete
                
                //TODO: Vett Franchiser has valid subscription and redirect to signup stage if not.
                return false;

                break;
            
            case 3: // driver
                // log user out and send them to generic info page
                Yii::$app->user->logout();
                $ca=[
                    ['driver','index',true],
                    ['site','index',false]
                ];
                return $ca;
                return false;
                
                break;
            case 4: // manager
            case 6: // storeOwner
                // TODO: Vett storeowner has valid subscription and redirect to signup stage if not

                return false;
//                if(!$this->getUserHasStores()){
//                   array_push($ca,['store-add','index'],true);
//                }
//                if(!$this->getCompany()){
//                   array_push($ca,['store-add','index'],true);
//                }
            case 7: // employee
                // TODO: Make sure employee's store is valid with valid supbscription
                //          Make sure employee details are valid
                return false;
                break;
            case 9: // menu aggregator
            case 12: // MAmanager
                // TODO: Nothing at this stage
                
                return false;
                break;
                
            default:
                return false;
        }
        
    }
    
    
    
    }
