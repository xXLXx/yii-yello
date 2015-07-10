<?php
namespace frontend\widgets\UserMenu;
use yii\base\Widget;

/**
 * Class UserMenuWidget
 *
 * @package frontend\widgets
 */
class UserMenuWidget extends Widget
{

    /**
     * User
     *
     * @var
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('default', ['user' => $this->user]);
    }
}