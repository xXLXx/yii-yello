<?php

namespace api\modules\v1\components;
use yii\db\ActiveRecord;

/**
 * Class Serializer
 *
 * Project-specific serializer
 *
 * @package api\molules\v1\components
 */

class Serializer extends \yii\rest\Serializer
{
    const SERIALIZER_ERROR_CODE_MODEL_VALIDATION = '101';

    const SERIALIZER_ERROR_MESSAGE_MODEL_VALIDATION = 'Model validation error';

    /**
     * Envelope which the error code should be sent within
     *
     * @var string
     */
    public $errorEnvelope;

    /**
     * Envelope which the error message should be sent within
     *
     * @var string
     */
    public $messageEnvelope;

    /**
     * Envelope which the single model should be sent within
     *
     * @var string
     */
    public $modelEnvelope;

    /**
     * @inheritdoc
     *
     * @param mixed $data
     * @return mixed
     */
    public function serialize($data)
    {
        $result = parent::serialize($data);
        if (isset($this->errorEnvelope) && empty($result[$this->errorEnvelope])) {
            $result[$this->errorEnvelope] = null;
        }
        return $result;
    }

    /**
     * @param ActiveRecord $model
     * @inheritdoc
     */
    public function serializeModel($model)
    {
        $result = parent::serializeModel($model);
        if (!empty($this->modelEnvelope)) {
            $result = [
                $this->modelEnvelope => $result,
            ];
        }
        if ($model->hasErrors() && !empty($this->errorEnvelope)) {
            if (!empty($this->errorEnvelope)) {
                $result[$this->errorEnvelope] = static::SERIALIZER_ERROR_CODE_MODEL_VALIDATION;
            }
            if (!empty($this->messageEnvelope)) {
                $result[$this->messageEnvelope] = static::SERIALIZER_ERROR_MESSAGE_MODEL_VALIDATION;
            }
        }
        return $result;
    }
}