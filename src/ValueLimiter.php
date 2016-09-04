<?php

/**
 * @license https://github.com/itomakiweb/php-utility/blob/master/LICENSE
 */

namespace Itomakiweb\Utility;

class ValueLimiter
{
    public function __construct()
    {
    }

    public function getRow(
        $rawRow,
        array $validRow
    ) {
        $row = [];
        foreach ($validRow as $key => $default) {
            if (is_array($default)) {
                $row[$key] = $this->getValueIfArray(
                    $rawRow,
                    $key,
                    $default
                );
            } else {
                $row[$key] = $this->getValueIfScalar(
                    $rawRow,
                    $key,
                    $default
                );
            }
        }

        return $row;
    }

    public function getValueIfArray(
        $rawRow,
        $key,
        $default = []
    ) {
        static $validFunc = 'is_array';

        return $this->getValueIfValid(
            $rawRow,
            $key,
            $default,
            $validFunc
        );
    }

    public function getValueIfScalar(
        $rawRow,
        $key,
        $default = ''
    ) {
        static $validFunc = 'is_scalar';

        return $this->getValueIfValid(
            $rawRow,
            $key,
            $default,
            $validFunc
        );
    }

    public function getValueIfValid(
        $rawRow,
        $key,
        $default = null,
        callable $validFunc = null
    ) {
        if (!is_array($rawRow)) {
            return $default;
        }
        if (!isset($rawRow[$key])) {
            return $default;
        }

        return $this->getIfValid(
            $rawRow[$key],
            $default,
            $validFunc
        );
    }

    public function getIfArray(
        $rawValue,
        $default = []
    ) {
        static $validFunc = 'is_array';

        return $this->getIfValid(
            $rawValue,
            $default,
            $validFunc
        );
    }

    public function getIfScalar(
        $rawValue,
        $default = ''
    ) {
        static $validFunc = 'is_scalar';

        return $this->getIfValid(
            $rawValue,
            $default,
            $validFunc
        );
    }

    public function getIfValid(
        $rawValue,
        $default = null,
        callable $validFunc = null
    ) {
        if (!$validFunc) {
            return $rawValue; // valid
        }

        $isValid = call_user_func(
            $validFunc,
            $rawValue
        );

        return $isValid ? $rawValue : $default;
    }
}
