<?php

namespace frontend\models;

use yii\base\Model;
use common\models\Shift;

/**
 * Company form
 *
 * @author markov
 */
class ShiftForm extends Model
{
    public $id;
    public $date;
    public $end_date;
    public $start;
    public $end;
    public $storeId;
    public $isVehicleProvided = 1;
    public $driverId;
    
    public $visibleGroup;
    public $isYelloDrivers;
    public $isFavourites;
    public $isMyDrivers;
    
    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            [
                [
                    'id', 'date', 'start', 'end', 'storeId', 'isVehicleProvided',
                    'driverId', 'isYelloDrivers', 'isFavourites', 'isMyDrivers',
                    'visibleGroup'
                ], 
                'safe'
            ],
            [
                ['date', 'start', 'end'], 'required'
            ],
            [
                ['date', 'end'], 'validateDateRange'
            ],
            [
                ['isMyDrivers'], 'validateDriver'
            ]
        ];
    }
    
    /**
     * Validate date range
     * 
     * @return boolean
     */
    public function validateDateRange()
    {

        $startDateTime = \DateTime::createFromFormat('d-m-Y H:i', $this->date." ".$this->start);
        $startDateTimestamp = $startDateTime->getTimestamp();

        if($startDateTimestamp < time()){
            $this->addError(
                'date', \Yii::t('app', 'Shifts can only be created in the future')
            );
        }

        $startMinutes = $this->time_to_minutes($this->start);
        $endMinutes = $this->time_to_minutes($this->end);
        $diff = $endMinutes - $startMinutes;

        if($diff < 0){ //check for next day
            $diff = 1440 + $diff;
            $this->end_date = date('Y-m-d', strtotime($this->date) + 24*3600);
        } else {
            $this->end_date = date('Y-m-d', strtotime($this->date));
        }

        $hours = $diff / 60;

        $minHours = 3;
        $maxHours = 8;

        if ($hours < $minHours) {
            $this->addError(
                'end', \Yii::t('app', 'Min. duration ' . $minHours . ' hours')
            );
        }
        if ($hours > $maxHours) {
            $this->addError(
                'end', \Yii::t('app', 'Max. duration ' . $maxHours . ' hours')
            );
        }
        return false;
    }

    private function time_to_minutes($time){

        $time = explode(':',$time);
        $minutes = $time[0]*60 + $time[1];
        return $minutes;

    }

    /*public function validateDateRange()
    /*public function validateDateRange()
    {

        $startDateTime = \DateTime::createFromFormat('H:i', $this->start);
        $endDateTime = \DateTime::createFromFormat('H:i', $this->end);
        $interval = $endDateTime->diff($startDateTime);
        $hours = $interval->format('%h%');

        $minHours = 3;
        $maxHours = 8;

        if ($hours < $minHours) {
            $this->addError(
                'end', \Yii::t('app', 'Min. duration ' . $minHours . ' hours')
            );
        }
        if ($hours > $maxHours) {
            $this->addError(
                'end', \Yii::t('app', 'Max. duration ' . $maxHours . ' hours')
            );
        }
        return false;
    }*/
    
     /**
     * Validate driver
     * 
     * @return boolean
     */
    public function validateDriver()
    {
        if (!count($this->visibleGroup)) {
            $this->addError(
                'isMyDrivers', \Yii::t('app', 'No option selected for Driver.')
            );
        }

        if (!$this->isMyDrivers) {
            return true;
        }
        if (!$this->driverId) {
            $this->addError(
                'isMyDrivers', \Yii::t('app', 'The driver is not selected')
            );
        }
    }
    
    /**
     * Set data
     * 
     * @param Shift $shift shift
     */
    public function setData($shift)
    {
        $this->setAttributes($shift->getAttributes());
        if ($shift->start) {
            $start = \DateTime::createFromFormat(
                'Y-m-d H:i:s', $shift->start
            );
            $this->date = $start->format('d-m-Y');
            $this->start = $start->format('H:i');
        }
        if ($shift->end) {
            $end = \DateTime::createFromFormat(
                'Y-m-d H:i:s', $shift->end
            );
            $this->end = $end->format('H:i');
        }
        $this->driverId = $shift->drivers ? $shift->drivers[0]['id'] : 0;
        $get = \Yii::$app->request->get();
        $this->load($get);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        $this->isFavourites = false;
        $this->isMyDrivers = false;
        $this->isYelloDrivers = false;

        if(isset($this->visibleGroup) && is_array($this->visibleGroup)){
            foreach($this->visibleGroup as $visibleGroup){
                $this->$visibleGroup = true;
            }
        }

        return parent::beforeValidate();
    }
    
    /**
     * Save
     */
    public function save() 
    {
        if (!$this->id) {
            $shift = new Shift();
            $shift->storeId = $this->storeId;
        } else {
            $shift = Shift::findOne($this->id);
            if (!$shift->isEditable()) {
                return $shift;
            }
        }
        $shift->setAttributes($this->getAttributes());
        $date = \DateTime::createFromFormat('d-m-Y', $this->date);
        $dateFormated = $date->format('Y-m-d');
        $shift->start = $dateFormated . ' ' . $this->start;
        $shift->end = $this->end_date . ' ' . $this->end;
        $shift->save();
        if ($this->driverId) {
            $shift->setStateAllocated($this->driverId);
        } else {
            $shift->setStatePending();
        }
        return $shift;
    }
    
    /**
     * Hours
     * 
     * @return array
     */
    public function getHours()
    {
        for ($i = 1; $i < 23; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }
    
    /**
     * Start hours
     * 
     * @return array
     */
    public function getStartHours()
    {
        $hours = $this->getHours();
        $result = [null => \Yii::t('app', 'Start')] + $hours; 
        return $result;
    }
    
    /**
     * End hours
     * 
     * @return array
     */
    public function getEndHours()
    {
        $hours = $this->getHours();
        $result = [null => \Yii::t('app', 'End')] + $hours;
        return $result;
    }
}

