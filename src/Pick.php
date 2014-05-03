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

    /**
     * @param array $array
     * @return array
     */
    public function readableSort($array)
    {
        $assoc = [];
        $hash  = [];
        foreach ($array as $key => $val) {
            is_numeric($val) ? $assoc[] = $val : $hash[$key] = $val;
        }

        foreach ($hash as $key => $val) {
            if (is_array($val)) {
                $val = $this->readableSort($val);
            }
            $hash[$key] = $val;
        }

        sort($assoc);
        asort($hash);

        return array_merge($assoc, $hash);
    }
}