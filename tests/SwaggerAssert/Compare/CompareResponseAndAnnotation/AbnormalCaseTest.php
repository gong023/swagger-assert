<?php
/**
 * Created by IntelliJ IDEA.
 * User: wanna_be_170
 * Date: 2014/05/11
 * Time: 13:56
 */

namespace SwaggerAssert\Compare\CompareResponseAndAnnotation;

use SwaggerAssert\Container\Actual;
use SwaggerAssert\Container\Expected;
use SwaggerAssert\Compare\CompareResponseAndAnnotation;
use SwaggerAssert\Compare\CompareResponseAndAnnotationTests;

class AbnormalCaseTest extends CompareResponseAndAnnotationTests
{
    /**
     * @test
     * @expectedException \SwaggerAssert\Exception\CompareException
     */
    public function tooManyActualKey()
    {
        $expected = new Expected();
        $expected->push('a');
        $expected->push('b');
        $expected->push('c');

        $actual = new Actual();
        $actual->push('a');
        $actual->push('b');
        $actual->push('c');
        $actual->push('d');

        $picker = $this->createPickerMock($expected, $actual);
        $subject = new CompareResponseAndAnnotation($picker);

        $subject->execute();
    }

    /**
     * @test
     * @expectedException \SwaggerAssert\Exception\CompareException
     */
    public function tooManyExpectedKey()
    {
        $expected = new Expected();
        $expected->push('a');
        $expected->push('b');
        $expected->push('c');

        $actual = new Actual();
        $actual->push('a');
        $actual->push('b');

        $picker = $this->createPickerMock($expected, $actual);
        $subject = new CompareResponseAndAnnotation($picker);

        $subject->execute();
    }
}
