<?php
/**
 * Rest-v1-specific Shift model
 */

namespace api\modules\v1\models;

use common\models\ShiftHasDriver;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * Class Shift
 * @package api\modules\v1\models
 *
 * @property bool $isAppliedByMe
 * @property bool $isAcceptedByStoreOwner
 * @property bool $isDeclinedByStoreOwner
 *
 * @property ShiftState $shiftState
 * @property Store $store
 * @property ShiftHasDriver[] $myApplications
 * @property ShiftStateLog[] $shiftStateLogs Shift state log rows
 */

class Shift extends \api\common\models\Shift implements Linkable
{
    /**
     * @inheritdoc
     */
    protected static $_namespace = __NAMESPACE__;

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['shift/view', 'id' => $this->id,], true),
        ];
    }

    /**
     * Check whether the currently authorized Driver has applied to this Shift and the Store Owner has accepted it
     *
     * @return bool
     */
    public function getIsAcceptedByStoreOwner()
    {
        if (!$this->isAppliedByMe) {
            return false;
        }
        $applications = $this->myApplications;
        foreach ($applications as $application) {
            if ($application->acceptedByStoreOwner) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check whether the currently authorized Driver has applied to this Shift
     *
     * @return bool
     */
    public function getIsAppliedByMe()
    {
        $applications = $this->myApplications;
        return !empty($applications) && is_array($applications) && count($applications);
    }

    /**
     * Check whether the currently authorized Driver has applied to this Shift and the Store Owner has accepted it
     *
     * @return bool
     */
    public function getIsDeclinedByStoreOwner()
    {
        if (!$this->isAppliedByMe) {
            return false;
        }
        $applications = $this->myApplications;
        foreach ($applications as $application) {
            if ($application->isDeclinedByStoreOwner) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get all applications of the currently authorized Driver to this Shift
     *
     * @return ActiveQuery
     */
    public function getMyApplications()
    {
        $driver = Driver::getCurrent();
        if (empty($driver)) {
            return null;
        }
        return $this
            ->getShiftHasDrivers()
            ->where([
                'driverId' => $driver->getId(),
                'isArchived' => 0
            ]);
    }
}