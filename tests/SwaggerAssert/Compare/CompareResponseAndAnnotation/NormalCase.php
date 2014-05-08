<?php

namespace SwaggerAssert\Compare\CompareResponseAndAnnotation;

use SwaggerAssert\Container\Actual;
use SwaggerAssert\Container\Expected;
use SwaggerAssert\Compare\CompareResponseAndAnnotation;
use SwaggerAssert\Compare\CompareResponseAndAnnotationTest;

class NormalCase extends CompareResponseAndAnnotationTest
{
    /**
     * @test
     * @dataProvider simpleCaseProvider
     */
    public function simpleCase($expectedMockVal, $actualMockVal)
    {
        $expected = new Expected();
        $expected->push($expectedMockVal[0]);
        $expected->push($expectedMockVal[1]);
        $expected->push($expectedMockVal[2]);

        $actual = new Actual();
        $actual->push($actualMockVal[0]);
        $actual->push($actualMockVal[1]);
        $actual->push($actualMockVal[2]);

        $picker = $this->createPickerMock($expected, $actual);
        $subject = new CompareResponseAndAnnotation($picker);

        $this->assertTrue($subject->_execute());
    }

    /**
     * @return array
     */
    public static function simpleCaseProvider()
    {
        return [
            [['a', 'b', 'c'], ['a', 'b', 'c']],
            [['c', 'b', 'a'], ['a', 'b', 'c']],
            [['a', 'b', 'c'], ['c', 'b', 'a']],
        ];
    }

    /**
     * @test
     */
    public function nestCase()
    {
        $expected = new Expected();
        $expected->push('a');
        $expected->push('b', new Expected('c'));
        $expected->push('d', new Expected('e', new Expected('f')));

        $actual = new Actual();
        $actual->push('a');
        $actual->push('b', new Actual('c'));
        $actual->push('d', new Actual('e', new Actual('f')));

        $picker = $this->createPickerMock($expected, $actual);
        $subject = new CompareResponseAndAnnotation($picker);

        $this->assertTrue($subject->_execute());
    }
}