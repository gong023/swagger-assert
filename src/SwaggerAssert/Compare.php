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

    /**
     * fail message when compared keys do not match
     *
     * @param array $actualKeys
     * @param array $expectedKeys
     * @return string
     */
    abstract protected function failMessage($actualKeys, $expectedKeys);

    /**
     * @param array $array
     * @return array
     */
    protected function readableSort($array)
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
