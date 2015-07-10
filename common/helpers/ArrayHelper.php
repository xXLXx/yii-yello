<?php

namespace common\helpers;

/**
 * Array helper extended
 *
 * @author markov
 */
class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Get array map
     * 
     * @param array $items items
     * @param string $field field name
     */
    public static function getArrayMap($items, $field)
    {
        $result = [];
        foreach ($items as $item) {
            $result[$item['id']] = $item[$field];
        }
        return $result;
    }

    /**
     * Group array items by field
     *
     * @param array             $array Grouping array of arrays or objects
     * @param string|callable   $key   Field name or anonymous function returning a key field name
     * @return array
     */
    public static function group(array $array = [], $key)
    {
        $result = [];
        foreach ($array as $index => $item) {
            $itemKey = is_callable($key) ?
                $key($item) :
                (
                is_object($item) ?
                    $item->$key :
                    $item[$key]
                );
            if (empty($result[$itemKey]) || !is_array($result[$itemKey])) {
                $result[$itemKey] = [];
            }
            $result[$itemKey][$index] = $item;
        }
        return $result;
    }
}
