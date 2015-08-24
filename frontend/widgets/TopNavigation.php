<?php
namespace frontend\widgets;

use common\models\Store;
use yii\base\Widget;
use common\models\User;
use common\models\Role;
use yii\helpers\Url;
/**
 * Class TopNavigation
 *
 * @desc Top navigation panel
 *
 * @package frontend\widgets
 */
class TopNavigation extends Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $user = \Yii::$app->user->identity;
        $store = $user->StoreCurrent;
        $timezone = $store->timezone;
        $date = new \DateTime('now', new \DateTimeZone($timezone));
        $menuItems = $this->getMenuItems($user);

        return $this->render('topNavigation', [
            'date' => $date,
            'user' => $user,
            'menuItems' => $menuItems,
            'context' => $this,
        ]);
    }

    /**
     * Add additional classes for menu item
     *
     * @param $class
     * @param $url
     * @return string
     */
    public function getItemClass( $class, $url )
    {
        // if url is array we compare it with current route
        if ( is_array($url) && $url[0] === Url::current() ) {
            $class .= ' active';
            // if url is string we compare it with url for current route
        } elseif ( is_string($url) && $url === Url::to(Url::current()) ) {
            $class .= ' active';
        }

        return $class;
    }

    /**
     * Get menu items for current user role
     *
     * @param User $user
     * @return array
     */
    private function getMenuItems( User $user )
    {
        $menuItems = [];
        $currentRoleName = $user->role->name;

        switch( $currentRoleName ) {
            case Role::ROLE_FRANCHISER:
                $menuItems = $this->getFranchiserMenuItems();
                break;
            case Role::ROLE_MENU_AGGREGATOR:
                $menuItems = $this->getMenuAggregatorMenuItems();
                break;
            default:
                $menuItems = $this->getDefaultMenuItems();
                break;
        }

        return $menuItems;
    }

    private function getFranchiserMenuItems()
    {
        return [
          //  ['label' => '', 'url' => ['/dashboard/index'], 'class' => 'item icon-pie-chart-1'],
            ['label' => '', 'url' => ['/stores-franchiser/index'], 'class' => 'item icon-shop'],
            ['label' => '', 'url' => ['/settings/index'], 'class' => 'item icon-setting-gears-2'],
        ];
    }

    private function getMenuAggregatorMenuItems()
    {
        return [
         //   ['label' => '', 'url' => ['/dashboard/index'], 'class' => 'item icon-pie-chart-1'],
            ['label' => '', 'url' => ['/store-menu-aggregator/index'], 'class' => 'item icon-shop'],
            ['label' => '', 'url' => ['/settings/index'], 'class' => 'item icon-setting-gears-2'],
        ];
    }

    private function getDefaultMenuItems()
    {
        return [
         //   ['label' => '', 'url' => ['/dashboard/index'], 'class' => 'item icon-pie-chart-1'],
            ['label' => '', 'url' => ['/shifts-calendar/index'], 'class' => 'item icon-calendar-2'],
            //['label' => '', 'url' => ['/store'], 'class' => 'item icon-shop'],
            ['label' => '', 'url' => ['/drivers/index'], 'class' => 'item icon-contacts-2'],
            ['label' => '', 'url' => ['/tracking/index'], 'class' => 'item icon-delivery'],
            ['label' => '', 'url' => ['/shift-list/index'], 'class' => 'item icon-check-1'],
            ['label' => '', 'url' => ['/settings/index'], 'class' => 'item icon-setting-gears-2'],
        ];
    }

}