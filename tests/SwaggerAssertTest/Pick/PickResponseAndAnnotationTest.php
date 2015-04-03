<?php

namespace SwaggerAssertTest\Pick;

use SwaggerAssert\Pick\PickResponseAndAnnotation;
use SwaggerAssertTest\TestBase;

class PickResponseAndAnnotationTest extends TestBase
{
    /**
     * @test
     */
    public function execute()
    {
        $sample = ['a', 'b', 'c'];
        $responseStub = $this->getMockBuilder('SwaggerAssert\Response')
            ->disableOriginalConstructor()->setMethods(['getActualByKeys'])->getMock();
        $responseStub->expects($this->once())->method('getActualByKeys')->will($this->returnValue($sample));

        $annotationStub = $this->getMockBuilder('SwaggerAssert\Annotation')
            ->disableOriginalConstructor()->setMethods(['getExpected'])->getMock();
        $annotationStub->expects($this->once())->method('getExpected')->will($this->returnValue($sample));

        $subject = new PickResponseAndAnnotation($responseStub, $annotationStub);
        $subject->execute();

        $this->assertEquals($sample, $subject->expected());
        $this->assertEquals($sample, $subject->actual());
    }
}
