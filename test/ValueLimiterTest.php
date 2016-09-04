<?php

/**
 * @license https://github.com/itomakiweb/php-utility/blob/master/LICENSE
 */

namespace Itomakiweb\Test\Utility;

use PHPUnit_Framework_TestCase;
use Itomakiweb\Utility\ValueLimiter;

class ValueLimiterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->valueLimiter = new ValueLimiter();
    }

    /**
     * @dataProvider providerGetIfValid
     */
    public function testGetIfValid(
        $rawValue,
        $default,
        callable $validFunc = null,
        $expected
    ) {
        $actual = $this->valueLimiter->getIfValid(
            $rawValue,
            $default,
            $validFunc
        );
        $this->assertEquals(
            $expected,
            $actual
        );
    }
    public function providerGetIfValid()
    {
        return [
            // validFunc: null, return raw
            'raw: null, validFunc: null' => [
                null,
                'default1',
                null,
                null,
            ],
            'raw: false, validFunc: null' => [
                false,
                'default1',
                null,
                false,
            ],
            'raw: true, validFunc: null' => [
                true,
                'default1',
                null,
                true,
            ],
            'raw: int(0), validFunc: null' => [
                0,
                'default1',
                null,
                0,
            ],
            'raw: int(not 0), validFunc: null' => [
                1,
                'default1',
                null,
                1,
            ],
            'raw: string(empty), validFunc: null' => [
                '',
                'default1',
                null,
                '',
            ],
            'raw: string(not empty), validFunc: null' => [
                'value1',
                'default1',
                null,
                'value1',
            ],
            'raw: array(empty), validFunc: null' => [
                [],
                'default1',
                null,
                [],
            ],
            'raw: array(not empty), validFunc: null' => [
                ['value1'],
                'default1',
                null,
                ['value1'],
            ],

            // validFunc: is_string, return raw or default
            'raw: null, validFunc: is_string' => [
                null,
                'default1',
                'is_string',
                'default1',
            ],
            'raw: false, validFunc: is_string' => [
                false,
                'default1',
                'is_string',
                'default1',
            ],
            'raw: true, validFunc: is_string' => [
                true,
                'default1',
                'is_string',
                'default1',
            ],
            'raw: int(0), validFunc: is_string' => [
                0,
                'default1',
                'is_string',
                'default1',
            ],
            'raw: int(not 0), validFunc: is_string' => [
                1,
                'default1',
                'is_string',
                'default1',
            ],
            'raw: string(empty), validFunc: is_string' => [
                '',
                'default1',
                'is_string',
                '',
            ],
            'raw: string(not empty), validFunc: is_string' => [
                'value1',
                'default1',
                'is_string',
                'value1',
            ],
            'raw: array(empty), validFunc: is_string' => [
                [],
                'default1',
                'is_string',
                'default1',
            ],
            'raw: array(not empty), validFunc: is_string' => [
                ['value1'],
                'default1',
                'is_string',
                'default1',
            ],
        ];
    }

    /**
     * @dataProvider providerGetIfScalar
     * @depends testGetIfValid
     */
    public function testGetIfScalar(
        $rawValue,
        $default,
        $expected
    ) {
        $actual = $this->valueLimiter->getIfScalar(
            $rawValue,
            $default
        );
        $this->assertEquals(
            $expected,
            $actual
        );
    }
    public function providerGetIfScalar()
    {
        return [
            // return raw or default
            'raw: null' => [
                null,
                'default1',
                'default1',
            ],
            'raw: false' => [
                false,
                'default1',
                false,
            ],
            'raw: true' => [
                true,
                'default1',
                true,
            ],
            'raw: int(0)' => [
                0,
                'default1',
                0,
            ],
            'raw: int(not 0)' => [
                1,
                'default1',
                1,
            ],
            'raw: string(empty)' => [
                '',
                'default1',
                '',
            ],
            'raw: string(not empty)' => [
                'value1',
                'default1',
                'value1',
            ],
            'raw: array(empty)' => [
                [],
                'default1',
                'default1',
            ],
            'raw: array(not empty)' => [
                ['value1'],
                'default1',
                'default1',
            ],
        ];
    }

    /**
     * @dataProvider providerGetIfArray
     * @depends testGetIfValid
     */
    public function testGetIfArray(
        $rawValue,
        $default,
        $expected
    ) {
        $actual = $this->valueLimiter->getIfArray(
            $rawValue,
            $default
        );
        $this->assertEquals(
            $expected,
            $actual
        );
    }
    public function providerGetIfArray()
    {
        return [
            // return raw or default
            'raw: null' => [
                null,
                ['default1'],
                ['default1'],
            ],
            'raw: false' => [
                false,
                ['default1'],
                ['default1'],
            ],
            'raw: true' => [
                true,
                ['default1'],
                ['default1'],
            ],
            'raw: int(0)' => [
                0,
                ['default1'],
                ['default1'],
            ],
            'raw: int(not 0)' => [
                1,
                ['default1'],
                ['default1'],
            ],
            'raw: string(empty)' => [
                '',
                ['default1'],
                ['default1'],
            ],
            'raw: string(not empty)' => [
                'value1',
                ['default1'],
                ['default1'],
            ],
            'raw: array(empty)' => [
                [],
                ['default1'],
                [],
            ],
            'raw: array(not empty)' => [
                ['value1'],
                ['default1'],
                ['value1'],
            ],
        ];
    }

    /**
     * @dataProvider providerGetValueIfValid
     * @depends testGetIfValid
     */
    public function testGetValueIfValid(
        $rawRow,
        $key,
        $default,
        callable $validFunc = null,
        $expected
    ) {
        $actual = $this->valueLimiter->getValueIfValid(
            $rawRow,
            $key,
            $default
        );
        $this->assertEquals(
            $expected,
            $actual
        );
    }
    public function providerGetValueIfValid()
    {
        return [
            // raw: not array, return default
            'raw: null' => [
                null,
                'key1',
                'default1',
                'is_string',
                'default1',
            ],
            'raw: false' => [
                false,
                'key1',
                'default1',
                'is_string',
                'default1',
            ],
            'raw: true' => [
                true,
                'key1',
                'default1',
                'is_string',
                'default1',
            ],
            'raw: int(0)' => [
                0,
                'key1',
                'default1',
                'is_string',
                'default1',
            ],
            'raw: int(not 0)' => [
                1,
                'key1',
                'default1',
                'is_string',
                'default1',
            ],
            'raw: string(empty)' => [
                '',
                'key1',
                'default1',
                'is_string',
                'default1',
            ],
            'raw: string(not empty)' => [
                'value1',
                'key1',
                'default1',
                'is_string',
                'default1',
            ],

            // raw: array(invalid), return default
            'raw: array(empty)' => [
                [],
                'key1',
                'default1',
                'is_string',
                'default1',
            ],
            'raw: array(not empty)' => [
                ['value1'],
                'key1',
                'default1',
                'is_string',
                'default1',
            ],

            // raw: array(valid), return raw value
            'raw: array(valid)' => [
                [
                    'key1' => 'value1',
                ],
                'key1',
                'default1',
                'is_string',
                'value1',
            ],
        ];
    }

    /**
     * @dataProvider providerGetValueIfScalar
     * @depends testGetValueIfValid
     */
    public function testGetValueIfScalar(
        $rawRow,
        $key,
        $default,
        $expected
    ) {
        $actual = $this->valueLimiter->getValueIfScalar(
            $rawRow,
            $key,
            $default
        );
        $this->assertEquals($expected, $actual);
    }
    public function providerGetValueIfScalar()
    {
        return [
            // raw: array(valid), return raw value
            'raw: array(valid)' => [
                [
                    'key1' => 'value1',
                ],
                'key1',
                'default1',
                'value1',
            ],
        ];
    }

    /**
     * @dataProvider providerGetValueIfArray
     * @depends testGetValueIfValid
     */
    public function testGetValueIfArray(
        $rawRow,
        $key,
        $default,
        $expected
    ) {
        $actual = $this->valueLimiter->getValueIfArray(
            $rawRow,
            $key,
            $default
        );
        $this->assertEquals($expected, $actual);
    }
    public function providerGetValueIfArray()
    {
        return [
            // raw: array(valid), return raw value
            'raw: array(valid)' => [
                [
                    'key1' => ['value1'],
                ],
                'key1',
                ['default1'],
                ['value1'],
            ],
        ];
    }

    /**
     * @dataProvider providerGetRow
     * @depends testGetValueIfScalar
     * @depends testGetValueIfArray
     */
    public function testGetRow(
        $rawRow,
        array $validRow,
        $expected
    ) {
        $actual = $this->valueLimiter->getRow(
            $rawRow,
            $validRow
        );
        $this->assertEquals(
            $expected,
            $actual
        );
    }
    public function providerGetRow()
    {
        return [
            // return mixed
            'raw/valid' => [
                [
                    'array/array' => ['value1'],
                    'array/string' => ['value1'],
                    'array/null' => ['value1'],
                    'string/array' => 'value2',
                    'string/string' => 'value2',
                    'string/null' => 'value2',
                    'null/array' => null,
                    'null/string' => null,
                    'null/null' => null,
                    'onlyRaw' => 'value4',
                ],
                [
                    'array/array' => ['default1'],
                    'array/string' => 'default1',
                    'array/null' => null,
                    'string/array' => ['default2'],
                    'string/string' => 'default2',
                    'string/null' => null,
                    'null/array' => ['default3'],
                    'null/string' => 'default3',
                    'null/null' => null,
                    'onlyValid' => 'default4',
                ],
                [
                    'array/array' => ['value1'],
                    'array/string' => 'default1',
                    'array/null' => null,
                    'string/array' => ['default2'],
                    'string/string' => 'value2',
                    'string/null' => 'value2',
                    'null/array' => ['default3'],
                    'null/string' => 'default3',
                    'null/null' => null,
                    'onlyValid' => 'default4',
                ],
            ],
        ];
    }
}
