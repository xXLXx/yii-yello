<?php

namespace console\controllers;

use common\rbac\UserRoleRule;
use Yii;
use yii\console\Controller;
use common\models\Role;
use yii\helpers\ArrayHelper;

class RbacController extends Controller
{
    /**
     * Let's add permissions based on matrix.
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $rule = new UserRoleRule();
        $auth->add($rule);

        /*** Permissions ***/

        $changeOwnPassword = $auth->createPermission('ChangeOwnPassword');
        $auth->add($changeOwnPassword);

        $changeOrgUsersPassword = $auth->createPermission('ChangeOrgUsersPassword');
        $auth->add($changeOrgUsersPassword);

        $changeOwnDetails = $auth->createPermission('ChangeOwnDetails');
        $auth->add($changeOwnDetails);

        $changeOrgUsersDetails = $auth->createPermission('ChangeOrgUsersDetails');
        $auth->add($changeOrgUsersDetails);

        $viewOrgUsersDetails = $auth->createPermission('ViewOrgUsersDetails');
        $auth->add($viewOrgUsersDetails);

        $addUsersToOrganisation = $auth->createPermission('AddUsersToOrganization');
        $auth->add($addUsersToOrganisation);

        $inviteUsersToOrganisation = $auth->createPermission('InviteUsersToOrganisation');
        $auth->add($inviteUsersToOrganisation);

        $approveDisableUsersFromOrganisation = $auth->createPermission('ApproveDisableUsersFromOrganisation');
        $auth->add($approveDisableUsersFromOrganisation);

        $approveDisableUsersSiteWide = $auth->createPermission('ApproveDisableUsersSiteWide');
        $auth->add($approveDisableUsersSiteWide);

        $createStore = $auth->createPermission('CreateStore');
        $auth->add($createStore);

        $createFranchisorOrganisation = $auth->createPermission('CreateFranchisorOrganisation');
        $auth->add($createFranchisorOrganisation);

        $editFranchisorOrganisation = $auth->createPermission('EditFranchisorOrganisation');
        $auth->add($editFranchisorOrganisation);

        $viewFranchisorOrganisation = $auth->createPermission('ViewFranchisorOrganisation');
        $auth->add($viewFranchisorOrganisation);

        $inviteStore = $auth->createPermission('InviteStore');
        $auth->add($inviteStore);

        $deleteStore = $auth->createPermission('DeleteStore');
        $auth->add($deleteStore);

        $viewOrganisationMembers = $auth->createPermission('ViewOrganisationMembers');
        $auth->add($viewOrganisationMembers);

        $viewOrganisationMemberPermissions = $auth->createPermission('ViewOrganisationMemberPermissions');
        $auth->add($viewOrganisationMemberPermissions);

        $updateOrganisationMemberPermissions = $auth->createPermission('UpdateOrganisationMemberPermissions');
        $auth->add($updateOrganisationMemberPermissions);

        $viewPaymentDetails = $auth->createPermission('ViewPaymentDetails');
        $auth->add($viewPaymentDetails);

        $editDriverPayment = $auth->createPermission('EditDriverPayment');
        $auth->add($editDriverPayment);

        $updatePaymentDetails = $auth->createPermission('UpdatePaymentDetails');
        $auth->add($updatePaymentDetails);

        $enableDisablePaymentMethod = $auth->createPermission('EnableDisablePaymentMethod');
        $auth->add($enableDisablePaymentMethod);

        $viewSubscription = $auth->createPermission('ViewSubscription');
        $auth->add($viewSubscription);

        $viewYelloPayments = $auth->createPermission('ViewYelloPayments');
        $auth->add($viewYelloPayments);

        $editSubscription = $auth->createPermission('EditSubscription');
        $auth->add($editSubscription);

        $editYelloPayments = $auth->createPermission('EditYelloPayments');
        $auth->add($editYelloPayments);

        $renewSubscription = $auth->createPermission('RenewSubscription');
        $auth->add($renewSubscription);

        $deleteFranchise = $auth->createPermission('DeleteFranchise');
        $auth->add($deleteFranchise);

        $suspendUserFromOrg = $auth->createPermission('SuspendUserFromOrg');
        $auth->add($suspendUserFromOrg);

        $createDriver = $auth->createPermission('CreateDriver');
        $auth->add($createDriver);

        $updateDriverInfo = $auth->createPermission('UpdateDriverInfo');
        $auth->add($updateDriverInfo);

        $deleteDriver = $auth->createPermission('DeleteDriver');
        $auth->add($deleteDriver);

        $viewTrackingMap = $auth->createPermission('ViewTrackingMap');
        $auth->add($viewTrackingMap);

        $createShift = $auth->createPermission('CreateShift');
        $auth->add($createShift);

        $updateShift = $auth->createPermission('UpdateShift');
        $auth->add($updateShift);

        $cancelShift = $auth->createPermission('CancelShift');
        $auth->add($cancelShift);

        $acceptApplicant = $auth->createPermission('AcceptApplicant');
        $auth->add($acceptApplicant);

        $rejectApplicant = $auth->createPermission('RejectApplicant');
        $auth->add($rejectApplicant);

        $approveShift = $auth->createPermission('ApproveShift');
        $auth->add($approveShift);

        $disputeShift = $auth->createPermission('DisputeShift');
        $auth->add($disputeShift);

        $resolveDispute = $auth->createPermission('ResolveDispute');
        $auth->add($resolveDispute);

        $favouriteDriver = $auth->createPermission('FavouriteDriver');
        $auth->add($favouriteDriver);

        $viewCalendar = $auth->createPermission('ViewCalendar');
        $auth->add($viewCalendar);

        $viewShiftLog = $auth->createPermission('ViewShiftLog');
        $auth->add($viewShiftLog);

        $viewStoreDashboard = $auth->createPermission('ViewStoreDashboard');
        $auth->add($viewStoreDashboard);

        $closeAccount = $auth->createPermission('CloseAccount');
        $auth->add($closeAccount);

        /*** Roles ***/

        // Let's add manually from matrix and roles table
        $superadmin = $auth->createRole('superAdmin');
        $superadmin->ruleName = $rule->name;
        $auth->add($superadmin);

        $franchiser = $auth->createRole('franchiser'); // Franchisor Owner Account
        $franchiser->ruleName = $rule->name;
        $auth->add($franchiser);

        $driver = $auth->createRole('driver'); // not on matrix
        $driver->ruleName = $rule->name;
        $auth->add($driver);

        $manager = $auth->createRole('manager'); // not on matrix
        $manager->ruleName = $rule->name;
        $auth->add($manager);

        $user = $auth->createRole('user'); // not on matrix
        $user->ruleName = $rule->name;
        $auth->add($user);

        $storeOwner = $auth->createRole('storeOwner'); // Store Account Owner
        $storeOwner->ruleName = $rule->name;
        $auth->add($storeOwner);

        // @todo: We dont have yet for Store Admin

        $employee = $auth->createRole('employee'); // Store Account User
        $employee->ruleName = $rule->name;
        $auth->add($employee);

        $yelloAdmin = $auth->createRole('yelloAdmin');
        $yelloAdmin->ruleName = $rule->name;
        $auth->add($yelloAdmin);

        // @todo: we dont have yet for yello staff

        $menuAggregator = $auth->createRole('menuAggregator'); // not on matrix
        $menuAggregator->ruleName = $rule->name;
        $auth->add($menuAggregator);

        $franchiseManager = $auth->createRole('franchiseManager'); // Franchisor Admin
        $franchiseManager->ruleName = $rule->name;
        $auth->add($franchiseManager);

        // @todo: we dont have franchise user (see matrix)

        $franchiseExtendedManager = $auth->createRole('franchiseExtendedManager'); // not on matrix
        $franchiseExtendedManager->ruleName = $rule->name;
        $auth->add($franchiseExtendedManager);

        $maManager = $auth->createRole('MAManager'); // not on matrix
        $maManager->ruleName = $rule->name;
        $auth->add($maManager);

        $maManagerExtended = $auth->createRole('MAManagerExtended'); // not on matrix
        $maManagerExtended->ruleName = $rule->name;
        $auth->add($maManagerExtended);

        // What the franchise manager have, the franchiser got it.
        $auth->addChild($franchiser, $franchiseManager);

        // What an employee have, the owner should have it too.
        $auth->addChild($storeOwner, $employee);

        // What those managers and owners have, the yellowadmin will have it, and so the superadmin
        $auth->addChild($yelloAdmin, $storeOwner);
        $auth->addChild($yelloAdmin, $franchiseManager);
        $auth->addChild($superadmin, $yelloAdmin);

        /*** Assignments ***/

        $auth->addChild($franchiseManager, $changeOwnPassword);
        $auth->addChild($franchiseManager, $changeOwnDetails);
        $auth->addChild($franchiseManager, $addUsersToOrganisation);
        $auth->addChild($franchiseManager, $inviteUsersToOrganisation);
        $auth->addChild($franchiseManager, $approveDisableUsersFromOrganisation);
        $auth->addChild($franchiseManager, $editFranchisorOrganisation);
        $auth->addChild($franchiseManager, $viewFranchisorOrganisation);
        $auth->addChild($franchiseManager, $inviteStore);
        $auth->addChild($franchiseManager, $deleteStore);
        $auth->addChild($franchiseManager, $viewOrganisationMembers);
        $auth->addChild($franchiseManager, $viewOrganisationMemberPermissions);
        $auth->addChild($franchiseManager, $updateOrganisationMemberPermissions);
        $auth->addChild($franchiseManager, $viewYelloPayments);
        $auth->addChild($franchiseManager, $viewTrackingMap);
        $auth->addChild($franchiseManager, $viewStoreDashboard);

        $auth->addChild($franchiser, $changeOrgUsersPassword);
        $auth->addChild($franchiser, $changeOrgUsersDetails);
        $auth->addChild($franchiser, $viewOrgUsersDetails);
        $auth->addChild($franchiser, $createFranchisorOrganisation);
        $auth->addChild($franchiser, $updatePaymentDetails);
        $auth->addChild($franchiser, $enableDisablePaymentMethod);
        $auth->addChild($franchiser, $deleteFranchise);
        $auth->addChild($franchiser, $suspendUserFromOrg);
        $auth->addChild($franchiser, $closeAccount);

        $auth->addChild($employee, $changeOwnPassword);
        $auth->addChild($employee, $changeOwnDetails);
        $auth->addChild($employee, $viewTrackingMap);
        $auth->addChild($employee, $createShift);
        $auth->addChild($employee, $updateShift);
        $auth->addChild($employee, $cancelShift);
        $auth->addChild($employee, $acceptApplicant);
        $auth->addChild($employee, $rejectApplicant);
        $auth->addChild($employee, $approveShift);
        $auth->addChild($employee, $disputeShift);
        $auth->addChild($employee, $resolveDispute);
        $auth->addChild($employee, $favouriteDriver);
        $auth->addChild($employee, $viewCalendar);
        $auth->addChild($employee, $viewShiftLog);
        $auth->addChild($employee, $viewStoreDashboard);

        $auth->addChild($storeOwner, $changeOrgUsersPassword);
        $auth->addChild($storeOwner, $viewPaymentDetails);
        $auth->addChild($storeOwner, $updatePaymentDetails);
        $auth->addChild($storeOwner, $enableDisablePaymentMethod);
        $auth->addChild($storeOwner, $deleteStore);
        $auth->addChild($storeOwner, $closeAccount);

        $auth->addChild($yelloAdmin, $approveDisableUsersSiteWide);
        $auth->addChild($yelloAdmin, $editSubscription);
        $auth->addChild($yelloAdmin, $editYelloPayments);
        $auth->addChild($yelloAdmin, $renewSubscription);
        $auth->addChild($yelloAdmin, $createDriver);
        $auth->addChild($yelloAdmin, $deleteDriver);

    }
}