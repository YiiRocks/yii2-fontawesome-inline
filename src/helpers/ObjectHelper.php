<?php
namespace thoulah\fontawesome\helpers;

/**
 * ObjectHelper provides additional object functionality.
 */
class ObjectHelper extends \yii\base\BaseObject
{
    /**
     * Removes an item from an object and returns the value. If the key does not
     * exist in the object, the default value will be returned instead.
     * @param object $object the object to extract value from
     * @param string $key key name of the object element
     * @param mixed $default the default value to be returned if the specified key does not exist
     */
    public static function remove(&$object, string $key, $default = null)
    {
        if (is_object($object) && isset($object->$key)) {
            $value = $object->$key;
            unset($object->$key);
            return $value;
        }
        return $default;
    }
}
