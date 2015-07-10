<?php
/**
 * Rest-v1-specific Store model
 */

namespace api\modules\v1\models;

use common\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Store extends \api\common\models\Store implements Linkable
{
    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['image', 'shiftStates'];
    }


    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(
                [
                    'store/view',
                    'id' => $this->id,
                ],
                true
            ),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'title',
            'address1',
            'address2',
            'imageId',
            'storeImage' => function(Store $model) {
                return $model->image;
            },
            'contactPerson',
            'phone',
            'createdAt' => 'createdAtAsTimestamp',
            'createdAtAsDatetime',
            'updatedAt' => 'updatedAtAsTimestamp',
            'updatedAtAsDatetime',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getImage()
    {
        return $this
            ->hasOne(
                Image::className(),
                [
                    'id' => 'imageId',
                ]
            );
    }

    public function getShiftStates()
    {
        $shiftStates = ShiftState::find()->indexBy('id')->all();
        $shifts = Shift::find()
            ->where([
                'storeId' => $this->id,
            ])
            ->all()
        ;
        $groups = ArrayHelper::group($shifts, 'shiftStateId');
        $result = [];
        foreach ($groups as $shiftStateId => $stateShifts) {
            $shiftState = $shiftStates[$shiftStateId]->getAttributes();
            $shiftState['shifts'] = count($stateShifts);
            $shiftState['href'] = Url::to([
                'shift/search',
                'ShiftSearch' => [
                    'storeId' => $this->id,
                    'shiftStateId' => $shiftStateId,
                ]
            ]);
            $result[] = $shiftState;
        }
        return $result;
    }
}