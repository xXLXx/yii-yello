<?php
/**
 * Base class for fixtures
 *
 * @author markov
 */

namespace common\components;

use yii\test\ActiveFixture;

class BaseFixture extends ActiveFixture
{
    public function load()
    {
        return parent::load();
    }

    public function afterLoad()
    {
        $this->recalculateSequence();
    }


    public function unload()
    {
        $this->resetTable();
        return parent::unload();
    }
    
    /**
     * @inheritdoc
     */
    protected function getData()
    {
        if ($this->dataFile !== null) {
            if (strpos($this->dataFile, '.json') !== false) {
                $dataFile = \Yii::getAlias($this->dataFile);
                return json_decode(file_get_contents($dataFile), true);
            } 
        } 
        return parent::getData();            
    }

    /**
     * Calculate sequence value
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function recalculateSequence()
    {
        $table = $this->getTableSchema();

        if ($table->sequenceName !== null) {
            $this->db->createCommand()->resetSequence($table->fullName)->execute();
        }
    }
} 