<?php
namespace common\models;

use common\helpers\ImageResizeHelper;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Url;
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
 * @property string $phone phone number
 * @property string $phonetype handset type
 * @property integer $imageId imageId
 * @property Boolean $hasExtendedRights has extended rights
 * @property Boolean $isBlocked is user blocked
 * @property integer $signup_step_completed
 * @property User $parentUser parent user
 *
 * @property StoreOwner $storeOwner store Owner
 * @property StoreOwner $myStoreOwner store Owner
 * @property StoreOwner $parentStoreOwner
 * @property Company $company company
 * @property Franchiser $franchiser franchiser
 * @property MenuAggregator $menuAggregator Menu aggregator
 *
 * @property Role $role role
 * @property Image $image image
 * @property UserDriver $userDriver userDriver

 * @property UserHasCompany[] $userHasCompanies userHasCompanies

 * @property UserHasStore[] $userHasStores userHasStores
 * @property view_stores[] $stores stores
 * @property Message[] $message
 * @property Store $storeCurrent the current selected store
 * @property Vehicle $vehicle
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
            [['firstName', 'lastName', 'phone','phonetype', 'email', 'roleId', 'stores'], 'safe']
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
            'address',
            'company',
            'companyaddress',
            'message'
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
            'signup_step_completed',
            'phone',
            'phonetype',
            'profilePhotoUrl' => function () {
                return '/images/profile/'.$this->id;
            },
            'profilePhotoThumbUrl' => function () {
                return '/images/profile-thumb/'.$this->id;
            },
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
     * Get Messages for user that have not yet been sent
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        $time=time();
//         return $this->hasMany(Message::className(), ['idrecipuser' => 'id','sentvia'=>null,'received'=>null,'expires'=>['>'.time()]]);
        $msgs = $this->hasMany(Message::className(), ['idrecipuser' => 'id'])->where(['sentvia'=>null,'received'=>null,["expiresUTC","<$time"]]);
        return $msgs;
        
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
     * Get shiftReviews
     * @return ActiveQuery
     */
    public function getShiftReviews()
    {
        return $this->hasMany(ShiftReviews::className(), ['driverId' => 'id']);
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
     * All the stores this user has access.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAllStores()
    {
        return $this->storeOwner ? $this->storeOwner->getStores() : $this->getStores();
    }

    /**
     * @param $stores
     */
    public function setStores($stores)
    {
        if (empty($stores)) {
            return true;
        }

        foreach ($stores as $storeId) {
            $store = Store::findOne($storeId);
            $this->link('stores', $store);
        }
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
     * Set the email of the user.
     *
     * @param string email
     * @return bool
     */

    public function setEmail($email)
    {
        $this->email = $email;
        if($this->save()){
            return true;
        }else{
            return false;
        }
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
     * Quick getter to user's current store timezone.
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->getStoreCurrent()->timezone;
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
     * Get the storeowner record of this user.
     * Or parent if not available.
     *
     * @return \common\models\StoreOwner
     */
    public function getStoreOwner()
    {
        return $this->myStoreOwner ?: $this->parentStoreOwner;
    }

    /**
     * Get the parent user storeOwner
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentStoreOwner()
    {
        return $this->hasOne(StoreOwner::className(), ['userId' => 'parentId']);
    }

    /**
     * Get storeOwner
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMyStoreOwner()
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
     * Get Driver Shifts that are accepted by store
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcceptedShifts()
    {
        return $this->hasMany(Shift::className(), ['id' => 'shiftId'])
            ->via('acceptedShiftHasDriver');
    }

    /**
     * Get shiftHasDriver
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShiftHasDriver()
    {
        return $this->hasMany(ShiftHasDriver::className(), ['driverId' => 'id']);
    }

    /**
     * Get accepted shiftHasDriver
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcceptedShiftHasDriver()
    {
        return $this->getShiftHasDriver()
            ->where(['acceptedByStoreOwner' => 1]);
    }

    /**
     * Get driverHasStores
     * @return ActiveQuery
     */
    public function getDriverHasStores()
    {
        return $this->hasMany(DriverHasStore::className(), ['driverId' => 'id']);
    }

    /**
     * Get company
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['userfk' => 'id'])
            ->where(['isPrimary' => 1]);
    }

    /**
     * Get Company Address
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddress()
    {
        return $this->hasOne(CompanyAddress::className(), ['companyfk' => 'id'])
            ->via('company');
    }

    /**
     * Get Address
     *
     * @return \yii\db\ActiveRecord
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['idaddress' => 'addressfk'])
            ->via('companyAddress');
    }

    /**
     * Get vehicle.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['driverId' => 'id']);
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
                // make sure user has company
                $company=$this->company;
                if(!$company){
                    array_push($ca,['store-signup','index',true]);
                    return $ca;
                    }
                    array_push($ca,['store-signup','index',false]);
                    // make sure the user has a storeowner



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

    /**
     * Get index page the user is to be redirected to
     *
     * @return string|array
     */
    public function getIndexUrl ()
    {
        switch ($this->roleId){
            case 6:
            case 7:
            case 4:
                return ['shifts-calendar/index'];
            default:
                return ['shifts-calendar/index'];
        }
    }

    /**
     * Get average ratings of a driver based upon the shift ratings.
     *
     * @return string
     */
    public function getRatings(){
        if($this->shiftReviews){
            $review_sum = $count = 0;
            foreach($this->shiftReviews as $review){
                $review_sum += $review->stars;
                $count++;
            }
            return $review_sum/$count;
        } else {
            return 0;
        }
    }

    /**
     * The profile photo path pattern.
     *
     * @return string
     */
    public function getProfilePhotoPathPattern()
    {
        return '/userfiles/{id}/profile.png';
    }

    /**
     * The profile photo-thumb path pattern.
     *
     * @return string
     */
    public function getProfilePhotoThumbPathPattern()
    {
        return '/userfiles/{id}/profile-thumb.png';
    }

    /**
     * The profile photo path pattern.
     *
     * @return string
     */
    public function getProfileMapPathPattern()
    {
        return '/userfiles/{id}/profile-map.png';
    }

    /**
     * The initials path pattern.
     *
     * @return string
     */
    public function getInitialsMapPathPattern()
    {
        return '/userfiles/{id}/initials-map.png';
    }

    /**
     * The license photo path pattern.
     *
     * @return string
     */
    public function getVehicleRegistrationPathPattern()
    {
        return '/userfiles/{id}/vehicle.png';
    }

    /**
     * The license photo path pattern.
     *
     * @return string
     */
    public function getVehicleRegistrationThumbPathPattern()
    {
        return '/userfiles/{id}/vehicle-thumb.png';
    }

    /**
     * The license photo path pattern.
     *
     * @return string
     */
    public function getLicensePathPattern()
    {
        return '/userfiles/{id}/drviers-license.png';
    }

    /**
     * The profile photo url.
     *
     * @return string
     */
    public function getProfilePhotoUrl()
    {
        return \Yii::$app->params['uploadPath'].$this->getProfilePhotoPath();
    }

    /**
     * The profile photo path.
     *
     * @return string
     */
    public function getProfilePhotoPath()
    {
        return str_replace('{id}', $this->id, $this->getProfilePhotoPathPattern());
    }

    /**
     * The profile photo path.
     *
     * @return string
     */
    public function getProfilePhotoThumbPath()
    {
        return str_replace('{id}', $this->id, $this->getProfilePhotoThumbPathPattern());
    }

    /**
     * The profile photo path.
     *
     * @return string
     */
    public function getProfileMapPhotoPath()
    {
        return str_replace('{id}', $this->id, $this->getProfileMapPathPattern());
    }

    /**
     * The profile photo path.
     *
     * @return string
     */
    public function getInitialsMapPath()
    {
        return str_replace('{id}', $this->id, $this->getInitialsMapPathPattern());
    }

    /**
     * The profile photo path.
     *
     * @return string
     */
    public function getLicensePhotoPath()
    {
        return str_replace('{id}', $this->id, $this->getLicensePathPattern());
    }

    /**
     * The vehicle registration photo path.
     *
     * @return string
     */
    public function getVehicleRegistrationPhotoPath()
    {
        return str_replace('{id}', $this->id, $this->getVehicleRegistrationPathPattern());
    }

    /**
     * The vehicle registration photo thumb path.
     *
     * @return string
     */
    public function getVehicleRegistrationPhotoThumbPath()
    {
        return str_replace('{id}', $this->id, $this->getVehicleRegistrationThumbPathPattern());
    }

    /**
     * The license photo url.
     *
     * @return string
     */
    public function getLicensePhotoUrl()
    {
        return \Yii::$app->params['uploadPath'].str_replace('{id}', $this->id, $this->getLicensePathPattern());
    }

    /**
     * Upload profile photo, create thumb and other images.
     * Separate request for the marker utilizing existing implementation.
     *
     * @todo thumb should be done in the background via a queuing system.
     * @param  string $sourceFile path to source file
     * @return mixed
     * @throws \Exception
     */
    public function uploadProfilePhoto($sourceFile)
    {
        $sizes = [
            'original' => '/userfiles/'.$this->id.'/'.uniqid('profile').'.png',
            '300' => str_replace('{id}', $this->id, $this->getProfilePhotoPathPattern()),
            '100' => str_replace('{id}', $this->id, $this->getProfilePhotoThumbPathPattern()),
        ];

        $result = ImageResizeHelper::resizeAndUpload($sourceFile, $sizes);

        // We didnt get expected upload counts (3 sizes; see above)
        if (count($result) < 3) {
            throw new \Exception('Upload failed. Unable to upload all the sizes.');
        }

        $sizes = [
            '100' => str_replace('{id}', $this->id, $this->getProfileMapPathPattern()),
        ];
        $temporaryFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('driver', true).'.png';
        file_put_contents($temporaryFile, file_get_contents(Url::to(['/tracking/get-driver-marker', 'driverId' => $this->id, 'sourceFile' => $sourceFile], true), false,
            stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ])));

        if (empty(ImageResizeHelper::resizeAndUpload($temporaryFile, $sizes))) {
            throw new \Exception('Upload failed. Unable to upload driver marker.');
        }

        $sizes = [
            '100' => str_replace('{id}', $this->id, $this->getInitialsMapPathPattern()),
        ];
        $temporaryFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('driver_initials', true).'.png';
        file_put_contents($temporaryFile, file_get_contents(Url::to(['/tracking/get-driver-initials-marker', 'driverId' => $this->id], true), false,
            stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ])));

        if (empty(ImageResizeHelper::resizeAndUpload($temporaryFile, $sizes))) {
            throw new \Exception('Upload failed. Unable to upload driver initials.');
        }

        return $result['300'];
    }

    /**
     * Upload vehicle registration photo, create thumb.
     *
     * @todo thumb should be done in the background via a queuing system.
     * @param  string $sourceFile path to source file
     * @return mixed
     * @throws \Exception
     */
    public function uploadVehiclePhoto($sourceFile)
    {
        $sizes = [
            'original' => '/userfiles/'.$this->id.'/'.uniqid('vehicle').'.png',
            '300' => str_replace('{id}', $this->id, $this->getVehicleRegistrationPathPattern()),
            '100' => str_replace('{id}', $this->id, $this->getVehicleRegistrationThumbPathPattern()),
        ];

        $result = ImageResizeHelper::resizeAndUpload($sourceFile, $sizes);

        // We didnt get expected upload counts (3 sizes; see above)
        if (count($result) < 3) {
            throw new \Exception('Upload failed. Unable to upload all the sizes.');
        }

        return $result['original'];
    }

    /**
     * Upload drivers license.
     *
     * @todo thumb should be done in the background via a queuing system.
     * @param  string $sourceFile path to source file
     * @return mixed
     * @throws \Exception
     */
    public function uploadLicensePhoto($sourceFile)
    {
        $sizes = [
            'original' => '/userfiles/'.$this->id.'/'.uniqid('license').'.png',
            '300' => str_replace('{id}', $this->id, $this->getLicensePathPattern()),
        ];

        $result = ImageResizeHelper::resizeAndUpload($sourceFile, $sizes);

        // We didnt get expected upload counts (2 sizes; see above)
        if (count($result) < 2) {
            throw new \Exception('Upload failed. Unable to upload all the sizes.');
        }

        return $result['original'];
    }

}
