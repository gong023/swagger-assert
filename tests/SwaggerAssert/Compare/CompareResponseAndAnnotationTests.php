<?php

namespace SwaggerAssert\Compare;

use SwaggerAssert\TestBase;

class CompareResponseAndAnnotationTests extends TestBase
{
    /**
     * @param \SwaggerAssert\Container\Expected $expected
     * @param \SwaggerAssert\Container\Actual $actual
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createPickerMock($expected, $actual)
    {
        $pickerStub = $this->getMockBuilder('SwaggerAssert\PickInterface')->setMethods(['execute', 'expected', 'actual'])->getMock();
        $pickerStub->expects($this->any())->method('execute')->will($this->returnValue(null));
        $pickerStub->expects($this->any())->method('expected')->will($this->returnValue($expected));
        $pickerStub->expects($this->any())->method('actual')->will($this->returnValue($actual));

        return $pickerStub;
    }
} 