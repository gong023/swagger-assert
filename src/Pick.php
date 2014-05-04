<?php

namespace SwaggerAssert;

/**
 * Class Pick
 * conscious of command pattern
 */
abstract class Pick
{
    /** @var array $expected */
    protected $expected;

    /** @var array $actual */
    protected $actual;

    /**
     * pick keys to assert
     * set expected,actual property
     */
    abstract function execute();

    /**
     * @return array
     */
    public function expected()
    {
        return $this->expected;
    }

    /**
     * @return array
     */
    public function actual()
    {
        return $this->actual;
    }
}