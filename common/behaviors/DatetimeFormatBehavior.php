<?php

namespace common\behaviors;
use common\components\Formatter;
use yii\base\UnknownMethodException;
use yii\base\UnknownPropertyException;

/**
 * Class DatetimeFormatBehavior
 *
 * Behavior formatting date-time fields of Active Record model.
 *
 * @author LiverEnemy
 * @package common\behaviors
 */

class DatetimeFormatBehavior extends BaseBehavior
{
    const ATTRIBUTES_STRING = 'stringAttributes';
    const ATTRIBUTES_TIMESTAMP = 'timestampAttributes';
    const TYPE_STRING = 'string';
    const TYPE_TIMESTAMP = 'timestamp';

    /**
     * Needed method names
     *
     * @var array
     */
    protected $_methods = [
        'Date',
        'Datetime',
        'Time',
        'Timestamp',
    ];

    /**
     * String attributes to format
     *
     * @var array|string[]
     */
    public $stringAttributes = [];

    /**
     * Timestamp attributes to format
     *
     * @var array
     */
    public $timestampAttributes = [];

    /**
     * Returns the value formatted as date-time
     *
     * $name must contain a valid attribute specified in one of the arrays above.
     *
     * @param string $property the property name
     * @return string the property value
     * @throws UnknownPropertyException if the property is not defined
     */
    public function __get($property)
    {
        if (!$this->canGetProperty($property)) {
            return parent::__get($property);
        }

        $format = $this->_getAttributeFormat($property);
        $name = $this->_getAttributeName($property);
        $type = $this->_getAttributeType($name);
        $owner = $this->owner;
        if (empty($owner->$name)) {
            return null;
        }
        $value = $owner->$name;
        return $this->translate($value, $type, $format);
    }

//    public function __set($property, $value)
//    {
//
//    }

    /**
     * @param $name
     * @return bool
     */
    protected function _attributeExists($name)
    {
        return (bool) $this->_getAttributeType($name);
    }

    /**
     * Get a getter-function name for the specified attribute
     *
     * @param $name
     * @return null|string
     */
    protected function _getAttributeType($name)
    {
        if (in_array($name, $this->stringAttributes)) {
            return static::TYPE_STRING;
        } elseif (in_array($name, $this->timestampAttributes)) {
            return static::TYPE_TIMESTAMP;
        }
        return null;
    }

    /**
     * Extract a name of the attribute to format from the specified property name
     *
     * @param string $property
     * @return string|null
     */
    protected function _getAttributeName($property)
    {
        $format = $this->_getAttributeFormat($property);
        if (empty($format)) {
            return null;
        }
        return str_ireplace("as" . $format, "", $property);
    }

    /**
     * Extract formatter method from the specified property name
     *
     * @param string $property
     * @return string|null
     */
    protected function _getAttributeFormat($property)
    {
        foreach ($this->_methods as $methodName) {
            $pos = stripos($property, $methodName);
            if ($pos !== false) {
                if (strlen($property) > $pos + strlen($methodName)) {
                    continue;
                }
                return $methodName;
            }
        }
        return null;
    }

    /**
     * Check whether this class can work with the specified property
     *
     * @param string $property Property name to check
     * @return bool
     */
    protected function _isMy($property)
    {
        $format = $this->_getAttributeFormat($property);
        if (empty($format)) {
            return false;
        }
        $name = $this->_getAttributeName($property);
        if (empty($name)) {
            return false;
        }
//        $owner = $this->owner;
//        if (!property_exists($owner, $name)) {
//            return false;
//        }
        $type = $this->_getAttributeType($name);
        if (empty($type)) {
            return false;
        }
        return true;
    }

    /**
     * Get a DateTime object from a date string
     *
     * @param string $value
     * @return \DateTime|null
     */
    protected function _parseFromDate($value)
    {
        return $this->getDatetime($value, static::TYPE_STRING);
    }

    /**
     * Get a DateTime object from a datetime string
     *
     * @param string $value
     * @return \DateTime|null
     */
    protected function _parseFromDatetime($value)
    {
        return $this->getDatetime($value, static::TYPE_STRING);
    }

    /**
     * Get a DateTime object from a time string
     *
     * @param string $value
     * @return \DateTime|null
     */
    protected function _parseFromTime($value)
    {
        return $this->getDatetime($value, static::TYPE_STRING);
    }

    /**
     * Get a DateTime object from a timestamp integer value
     *
     * @param integer $value
     * @return \DateTime|null
     */
    protected function _parseFromTimestamp($value)
    {
        return $this->getDatetime($value, static::TYPE_TIMESTAMP);
    }

    /**
     * Translate a DateTime into date string
     *
     * @param \DateTime $dt DateTime to translate
     * @return string
     */
    protected function _translateIntoDate(\DateTime $dt)
    {
        return $this
            ->getFormatter()
            ->asDate($dt);
    }

    /**
     * Translate a DateTime into datetime string
     *
     * @param \DateTime $dt DateTime to translate
     * @return string
     */
    protected function _translateIntoDatetime(\DateTime $dt)
    {
        return $this
            ->getFormatter()
            ->asDatetime($dt);
    }

    /**
     * Translate a DateTime into time string
     *
     * @param \DateTime $dt DateTime to translate
     * @return string
     */
    protected function _translateIntoTime(\DateTime $dt)
    {
        return $this
            ->getFormatter()
            ->asTime($dt);
    }

    /**
     * Translate a DateTime into time string
     *
     * @param \DateTime $dt DateTime to translate
     * @return string
     */
    protected function _translateIntoTimestamp(\DateTime $dt)
    {
        return $this
            ->getFormatter()
            ->asTimestamp($dt);
    }

    /**
     * @inheritdoc
     */
    public function canGetProperty($property, $checkVars = true)
    {
        if (parent::canGetProperty($property, $checkVars)) {
            return true;
        }
        return $this->_isMy($property);
    }

    /**
     * @inheritdoc
     */
    public function canSetProperty($property, $checkVars = true)
    {
        if (parent::canSetProperty($property, $checkVars)) {
            return true;
        }
        return $this->_isMy($property);
    }

    /**
     * Get DateTime object from a value of the known type
     *
     * @param string $value Value to process
     * @param string $type Value type (string, timestamp or another)
     * @return \DateTime|null
     */
    public function getDatetime($value, $type)
    {
        switch (strtolower($type)) {
            case static::TYPE_STRING:
                return new \DateTime($value);
            case static::TYPE_TIMESTAMP:
                $dateTime = new \DateTime();
                $dateTime->setTimestamp($value);
                return $dateTime;
        }
        return null;
    }

    /**
     * Get an application formatter
     *
     * @return Formatter
     */
    public function getFormatter()
    {
        return \Yii::$app->formatter;
    }

    /**
     * @param string $value  Translating value
     * @param string $type   Type of the translating value: String or Timestamp
     * @param string $format Format which to translate a value in: Date, Datetime, Time or Timestamp
     * @return null
     */
    public function translate($value, $type, $format)
    {
        $dt = $this->getDatetime($value, $type);
        if (empty($dt)) {
            return null;
        }
        $method = '_translateInto' . ucfirst($format);
        if (!method_exists($this, $method)) {
            throw new UnknownMethodException("Such method does not exist: " . $this->className() . "::" . $method);
        }
        return $this->$method($dt);
    }
}