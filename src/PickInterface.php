<?php

namespace SwaggerAssert;

/**
 * interface Pick
 * conscious of command pattern
 */
interface PickInterface
{
    /**
     * pick keys to assert
     * set expected,actual property
     */
    public function execute();

    /**
     * @return \SwaggerAssert\Container\Expected
     */
    public function expected();

    /**
     * @return \SwaggerAssert\Container\Actual
     */
    public function actual();
}