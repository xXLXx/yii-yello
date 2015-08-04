<?php
/**
 * v1-specific restful model for ShiftState
 */

namespace api\modules\v1\models;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class ShiftState extends \api\common\models\ShiftState implements Linkable
{
    
    

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(
                [
                    'shiftstate/view',
                    'id' => $this->id,
                ],
                true
            ),
        ];
    }    
//    
//    public function extraFields()
//    {
//        return ['shifts'];
//    }
//
//    /**
//     * @inheritdoc
//     */
//    public function fields()
//    {
//        return [
//            'id',
//            'name',
//            'title',
//            'color',
//        ];
//    }
//
//    public function getAll(){
//        return ShiftState::findAll();
//    }






    /**
     * @inheritdoc
     */
    public static function shiftClass()
    {
        return Shift::className();
    }
}