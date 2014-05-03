<?php
namespace SwaggerAssert;

/**
 * Class Compare
 * conscious of command pattern
 */
abstract class Compare
{
    /**
     * compare expected keys and actual keys
     *
     * @return array
     */
    abstract public function execute();
}
