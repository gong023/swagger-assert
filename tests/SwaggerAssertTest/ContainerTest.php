<?php
namespace SwaggerAssertTest;

use SwaggerAssert\Container;
use SwaggerAssert\Container\Actual;

class ContainerTest extends TestBase
{
    /**
     * @test
     * @return Actual
     */
    public function setWithoutValue()
    {
        $subject = new Container();
        $subject->push('sample');
        $this->assertNull($subject->sample);

        return $subject;
    }

    /**
     * @test
     * @depends setWithoutValue
     * @param Container $subject
     */
    public function keysWithoutValue($subject)
    {
        $this->assertEquals(['sample'], $subject->keys());
    }

    /**
     * @test
     * @return Container
     */
    public function setWithValue()
    {
        $subject = new Actual();
        $subject->push('sample', new Actual('nest'));
        $this->assertNotNull($subject->sample);

        return $subject;
    }

    /**
     * @test
     * @depends setWithValue
     */
    public function keysWithValue($subject)
    {
        $this->assertInstanceOf('SwaggerAssert\Container\Actual', $subject->sample);
    }
}