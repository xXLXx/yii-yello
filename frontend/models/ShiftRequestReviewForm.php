<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\ShiftRequestReview;
use yii\web\NotFoundHttpException;

/**
 * Shift request review form
 *
 * @author markov
 */
class ShiftRequestReviewForm extends Model
{
    public $id;
    public $title;
    public $text;
    public $shiftId;
    public $deliveryCount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['shiftId', 'id'], 'integer'],
            [['deliveryCount', 'id'], 'integer']
        ];
    }
    
    /**
     * Set data
     * 
     * @param integer $shiftRequestReviewId shiftRequestReview id
     * @throws NotFoundHttpException
     */
    public function setData($shiftRequestReviewId) 
    {
        if ($shiftRequestReviewId) {
            $shiftRequestReview = ShiftRequestReview::findOne($shiftRequestReviewId);
            if (!$shiftRequestReview) {
                throw new NotFoundHttpException('ShiftRequestReview not found');
            }
            $this->setAttributes($shiftRequestReview->getAttributes());
        } 
    }
    
    /**
     * Save
     * 
     * @return ShiftRequestReview
     */
    public function save() 
    {
        if (!$this->id) {
            $shiftRequestReview = new ShiftRequestReview();
        } else {
            $shiftRequestReview = ShiftRequestReview::findOne($this->id);
        }
        $shiftRequestReview->setAttributes($this->getAttributes());
        $shiftRequestReview->deliveryCount = (int)$this->title;
        $shiftRequestReview->userId = (int)Yii::$app->user->identity->id;
        $shiftRequestReview->save();
        return $shiftRequestReview;
    }
}
