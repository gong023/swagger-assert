<?php
namespace SwaggerAssert;

/**
 * Class Compare
 * conscious of command pattern
 */
abstract class Compare
{
    abstract public function execute();

    abstract protected function failMessage();

    protected function readableSort()
    {

    }
}
