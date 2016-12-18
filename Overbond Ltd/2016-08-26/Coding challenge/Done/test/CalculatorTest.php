<?php

use CorporateBond\Challenge\Calculator;

class CalculatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->calculator = new Calculator();
    }

    // @todo: Take care of floats here as they may get different values on different machine (for example, x86 vs. 64)
    public function testCalculateYieldSpread()
    {
        $input = array(
            0 =>
                array(
                    'bond' => 'C1',
                    'type' => 'corporate',
                    'term' => 10.300000000000001,
                    'yield' => 5.2999999999999998,
                ),
            1 =>
                array(
                    'bond' => 'G1',
                    'type' => 'government',
                    'term' => 9.4000000000000004,
                    'yield' => 3.7000000000000002,
                ),
            2 =>
                array(
                    'bond' => 'G2',
                    'type' => 'government',
                    'term' => 12,
                    'yield' => 4.7999999999999998,
                ),
        );

        $output = array(
            'C1' =>
                array(
                    0 =>
                        array(
                            'bond' => 'G1',
                            'type' => 'government',
                            'term' => 9.4000000000000004,
                            'yield' => 3.7000000000000002,
                            '_yearsDiffAbs' => 0.90000000000000036,
                            'spread_to_benchmark' => 1.5999999999999996,
                        ),
                ),
        );

        $this->assertEquals($output, $this->calculator->calculateYieldSpread($input));

    }

    // @todo: Take care of floats here as they may get different values on different machine (for example, x86 vs. 64)
    public function testCalculateSpreadToCurve()
    {
        $input = array(
            0 =>
                array(
                    'bond' => 'C1',
                    'type' => 'corporate',
                    'term' => 10.300000000000001,
                    'yield' => 5.2999999999999998,
                ),
            1 =>
                array(
                    'bond' => 'C2',
                    'type' => 'corporate',
                    'term' => 15.199999999999999,
                    'yield' => 8.3000000000000007,
                ),
            2 =>
                array(
                    'bond' => 'G1',
                    'type' => 'government',
                    'term' => 9.4000000000000004,
                    'yield' => 3.7000000000000002,
                ),
            3 =>
                array(
                    'bond' => 'G2',
                    'type' => 'government',
                    'term' => 12,
                    'yield' => 4.7999999999999998,
                ),
            4 =>
                array(
                    'bond' => 'G3',
                    'type' => 'government',
                    'term' => 16.300000000000001,
                    'yield' => 5.5,
                ),
        );

        $output = array(
            0 =>
                array(
                    'bond' => 'C1',
                    'type' => 'corporate',
                    'term' => 10.300000000000001,
                    'yield' => 5.2999999999999998,
                    'spread_to_curve' => 1.2192307692307685,
                ),
            1 =>
                array(
                    'bond' => 'C2',
                    'type' => 'corporate',
                    'term' => 15.199999999999999,
                    'yield' => 8.3000000000000007,
                    'spread_to_curve' => 2.9790697674418611,
                ),
        );

        $this->assertEquals($output, $this->calculator->calculateSpreadToCurve($input));

    }
}