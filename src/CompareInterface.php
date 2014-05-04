<?php
namespace SwaggerAssert;

/**
 * Class Compare
 * conscious of command pattern
 */
interface CompareInterface
{
    /**
     * @param PickInterface $pick
     */
    public function __construct(PickInterface $pick);

    /**
     * compare expected keys and actual keys
     *
     * @return array
     */
    public function execute();
}
