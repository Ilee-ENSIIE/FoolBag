<?php

namespace App;

use App\sum as mySum;
use PHPUnit\Framework\TestCase;

class SumTest extends TestCase
{
    /**
     * Provide test data for the sum function
     */
    public function sumDataProvider()
    {
        return [
            [1, 2, 3],
            [1, -1, 0],
            [4, 8, 12],
            [PHP_INT_MAX, 0, PHP_INT_MAX],
        ];
    }

    /**
     * Test the sum function
     *
     * @dataProvider sumDataProvider
     * @param {int} $left
     * @param {int} $right
     * @param {int} $expected
     */
    public function testSum($left, $right, $expected)
    {
        $this->assertEquals($expected, mySum($left, $right));
    }
}