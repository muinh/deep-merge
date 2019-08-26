<?php

namespace App\AppBundle\Utils;

/**
 * Class ArrayMergeUtil
 *
 * @package App\AppBundle\Utils
 */
class ArrayMergeUtil
{
    /**
     * Deep merge of arrays.
     *
     * @param array $firstArray
     * @param array $secondArray
     * @param bool $ignoreNumericKeys
     * @return array
     */
    public static function deepMerge(array $firstArray, array $secondArray, bool $ignoreNumericKeys = true) : array
    {
        $result = [];

        foreach ($firstArray as $fKey => $fValue) {
            if (\is_numeric($fKey) && $ignoreNumericKeys === true) {
                /*
                 * If array has numeric key - let it be merged like simple data
                 */
                return array_merge($firstArray, $secondArray);
            }

            if (\is_array($fValue)) {
                $secondArrayValue = array_key_exists($fKey, $secondArray) ? (array) $secondArray[$fKey] : [];

                $result[$fKey] = self::deepMerge($fValue, $secondArrayValue);
            } else {
                $result[$fKey] = $secondArray[$fKey] ?? $fValue;
            }
        }

        foreach ($secondArray as $sKey => $sValue) {
            if (!array_key_exists($sKey, $result)) {
                $result[$sKey] = $sValue;
            }
        }

        return $result;
    }
}

