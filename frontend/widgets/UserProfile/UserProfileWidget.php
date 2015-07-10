<?php
namespace frontend\widgets\UserProfile;

use yii\base\Widget;

/**
 * Class UserProfileWidget
 *
 * @package frontend\widgets
 */
class userProfileWidget extends Widget
{

    /**
     * User
     *
     * @var \common\models\User
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('default', [
            'user' => $this->user
        ]);
    }
}