<?php
require_once __DIR__ . '/../../src/Arr.php';

class ArrTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $result = \PhpTool\Arr::column([['a' => 1], ['a' => 2]], 'a');

        $this->assertEquals($result, [1, 2]);
    }
}