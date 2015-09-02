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
            case Role::ROLE_STORE_OWNER:
                $menuItems = $this->getDefaultLinks();
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
        $items=[];
        $menuItems = [];
         $menuItems[] =    ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']];
         //$menuItems[] =    ['label' => \Yii::t('app', 'Company details'), 'url' => ['company-details/index']];
         //$menuItems[] =   ['label' => \Yii::t('app', 'Your Stores'), 'url' => ['your-stores/index']];
 
        $items[]=['heading'=>'Preferences','menuItems'=>$menuItems];
        return $items;
        
        
    }

    /**
     * @return array
     */
    private function getManagerLinks()
    {
       $items=[];
       $menuItems = [];

        
        
       // $menuItems[] = ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Manage Users'), 'url' => ['settings/users']];
    //    $menuItems[] = ['label' => \Yii::t('app', 'Plans & Pricing'), 'url' => ['settings/schedules']];
       // $menuItems[] = ['label' => \Yii::t('app', 'Default Roster'), 'url' => ['settings/roster']];
        $items[]=['heading'=>\Yii::t('app', 'Preferences'),'menuItems'=>$menuItems];
        $menuItems=[];
        $menuItems[] = ['label' => \Yii::t('app', 'Company details'), 'url' => ['company-details/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Your Stores'), 'url' => ['your-stores/index']];
        //$menuItems[] = ['label' => \Yii::t('app', 'Payment details'), 'url' => ['settings/bank']];
//        $menuItems[] = ['label' => \Yii::t('app', 'Invoices'), 'url' => ['settings/invoices']];
//        $menuItems[] = ['label' => \Yii::t('app', 'Pricing Schedules'), 'url' => ['settings/schedules']];
//        $menuItems[] = ['label' => \Yii::t('app', 'Yello Corporate'), 'url' => ['/settings/yello']];
        $items[]=['heading'=>\Yii::t('app', 'Company Account'),'menuItems'=>$menuItems];
                return $items;
        }

    /**
     * @return array
     */
    private function getDefaultLinks()
    {
        $items=[];
        $menuItems = [];
        $menuItems[] = ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Manage Users'), 'url' => ['settings/users']];
    //    $menuItems[] = ['label' => \Yii::t('app', 'Plans & Pricing'), 'url' => ['settings/schedules']];
       // $menuItems[] = ['label' => \Yii::t('app', 'Default Roster'), 'url' => ['settings/roster']];
        $items[]=['heading'=>\Yii::t('app', 'Preferences'),'menuItems'=>$menuItems];
        $menuItems=[];
        $menuItems[] = ['label' => \Yii::t('app', 'Company details'), 'url' => ['company-details/index']];
        $menuItems[] = ['label' => \Yii::t('app', 'Your Stores'), 'url' => ['your-stores/index']];
        //$menuItems[] = ['label' => \Yii::t('app', 'Payment details'), 'url' => ['settings/bank']];
//        $menuItems[] = ['label' => \Yii::t('app', 'Invoices'), 'url' => ['settings/invoices']];
//        $menuItems[] = ['label' => \Yii::t('app', 'Pricing Schedules'), 'url' => ['settings/schedules']];
//        $menuItems[] = ['label' => \Yii::t('app', 'Yello Corporate'), 'url' => ['/settings/yello']];
        $items[]=['heading'=>\Yii::t('app', 'Company Account'),'menuItems'=>$menuItems];
        
        return $items;
    }

    /**
     * @return array
     */
    private function getFranchiserLinks()
    {
        $items=[];
        $menuItems = [];
        $menuItems[]=             ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']];
        $menuItems[]=             ['label' => \Yii::t('app', 'Manage Users'), 'url' => ['settings-franchiser/users']];
        $menuItems[]=             ['label' => \Yii::t('app', 'Yello Corporate'), 'url' => ['/']];
        $menuItems[]=             ['label' => \Yii::t('app', 'Company Details'), 'url' => ['company-details-franchiser/index']];
        $menuItems[]=             ['label' => \Yii::t('app', 'Invitations'), 'url' => ['settings-franchiser/invitations']];
        $menuItems[]=             ['label' => \Yii::t('app', 'Bank Details'), 'url' => ['/']];
        $menuItems[]=             ['label' => \Yii::t('app', 'Invoices'), 'url' => ['/']];
        $items[]=['heading'=>\Yii::t('app', 'Preferences'),'menuItems'=>$menuItems];
        return $items;
    }

    /**
     * @return array
     */
    private function getMenuAggregatorLinks()
    {
        $items=[];
        $menuItems = [];
           $menuItems[]=  ['label' => \Yii::t('app', 'Manage Account'), 'url' => ['settings/index']];
          $menuItems[]=   ['label' => \Yii::t('app', 'Manage Users'), 'url' => ['settings-menu-aggregator/users']];
           $menuItems[]=  ['label' => \Yii::t('app', 'Yello Corporate'), 'url' => ['/']];
        $menuItems[]= ['label' => \Yii::t('app', 'Company Details'), 'url' => ['company-details/index']];
        $menuItems[]= ['label' => \Yii::t('app', 'Invitations'), 'url' => ['/']];
        $menuItems[]= ['label' => \Yii::t('app', 'Bank Details'), 'url' => ['/']];
        $menuItems[]= ['label' => \Yii::t('app', 'Invoices'), 'url' => ['/']];
        $items[]=['heading'=>\Yii::t('app', 'Preferences'),'menuItems'=>$menuItems];
        return $items;
        
    }

}