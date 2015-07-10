<?php
namespace frontend\widgets;

use common\models\Role;
use yii\base\Widget;

/**
 * Class SettingsLeftNavigation
 *
 * @desc Left navigation column on Settings page
 *
 * @package frontend\widgets
 */
class SettingsLeftNavigation extends Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $currentUserRoleName = \Yii::$app->user->identity->role->name;
        $menuItems = [];
        switch($currentUserRoleName) {
            case Role::ROLE_EMPLOYEE:
                $menuItems = $this->getEmployeeLinks();
                break;
            case Role::ROLE_MANAGER:
                $menuItems = $this->getManagerLinks();
                break;
            case Role::ROLE_FRANCHISER:
                $menuItems = $this->getFranchiserLinks();
                break;
            case Role::ROLE_MENU_AGGREGATOR:
                $menuItems = $this->getMenuAggregatorLinks();
                break;
            default:
                $menuItems = $this->getDefaultLinks();
                break;
        }

        return $this->render('settingsLeftNavigation', [
            'menuItems' => $menuItems
        ]);
    }

    /**
     * @return array
     */
    private function getEmployeeLinks()
    {
        return [
            ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']],
            ['label' => \Yii::t('app', 'Company details'), 'url' => ['company-details/index']],
            ['label' => \Yii::t('app', 'Your Stores'), 'url' => ['your-stores/index']]
        ];
    }

    /**
     * @return array
     */
    private function getManagerLinks()
    {
        $menuItems = [];
        $menuItems[] = ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Company details'), 'url' => ['company-details/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Your Stores'), 'url' => ['your-stores/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Invoices'), 'url' => ['settings/invoices']];
        $menuItems[] = ['label' => \Yii::t('app', 'Bank details'), 'url' => ['settings/bank']];
        $menuItems[] = ['label' => \Yii::t('app', 'Pricing Schedules'), 'url' => ['settings/schedules']];
        $menuItems[] = ['label' => \Yii::t('app', 'Yello Corporate'), 'url' => ['/settings/yello']];
        return $menuItems;
    }

    /**
     * @return array
     */
    private function getDefaultLinks()
    {
        $menuItems = [];
        $menuItems[] = ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Manage Users'), 'url' => ['settings/users']];
        $menuItems[] = ['label' => \Yii::t('app', 'Company details'), 'url' => ['company-details/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Your Stores'), 'url' => ['your-stores/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Invoices'), 'url' => ['settings/invoices']];
        $menuItems[] = ['label' => \Yii::t('app', 'Bank details'), 'url' => ['settings/bank']];
        $menuItems[] = ['label' => \Yii::t('app', 'Pricing Schedules'), 'url' => ['settings/schedules']];
        $menuItems[] = ['label' => \Yii::t('app', 'Yello Corporate'), 'url' => ['/settings/yello']];
        return $menuItems;
    }

    /**
     * @return array
     */
    private function getFranchiserLinks()
    {
        return [
            ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']],
            ['label' => \Yii::t('app', 'Manage Users'), 'url' => ['settings-franchiser/users']],
            ['label' => \Yii::t('app', 'Yello Corporate'), 'url' => ['/']],
            ['label' => \Yii::t('app', 'Company Details'), 'url' => ['company-details-franchiser/index']],
            ['label' => \Yii::t('app', 'Invitations'), 'url' => ['settings-franchiser/invitations']],
            ['label' => \Yii::t('app', 'Bank Details'), 'url' => ['/']],
            ['label' => \Yii::t('app', 'Invoices'), 'url' => ['/']],
        ];
    }

    /**
     * @return array
     */
    private function getMenuAggregatorLinks()
    {
        return [
            ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']],
            ['label' => \Yii::t('app', 'Manage Users'), 'url' => ['settings-menu-aggregator/users']],
            ['label' => \Yii::t('app', 'Yello Corporate'), 'url' => ['/']],
            ['label' => \Yii::t('app', 'Company Details'), 'url' => ['company-details/index']],
            ['label' => \Yii::t('app', 'Invitations'), 'url' => ['/']],
            ['label' => \Yii::t('app', 'Bank Details'), 'url' => ['/']],
            ['label' => \Yii::t('app', 'Invoices'), 'url' => ['/']],
        ];
    }

}