<?php

namespace SwaggerAssert;

use SwaggerAssert\Container\Actual;
use SwaggerAssert\Exception\ResponseException;

/**
 * Class Response
 */
class Response
{
    /** var array $rowData */
    private $rowData;

    /**
     * @param array $rowData
     */
    public function __construct(Array $rowData)
    {
        $this->rowData = $rowData;
    }

    /**
     * get Container instance by array of API response
     *
     * @throws ResponseException
     * @return Actual
     */
    public function getActualByKeys()
    {
        if ($this->isCollectionWhichDoesNotHaveHash($this->rowData)) {
            throw new ResponseException('response has no keys. you cannot use response which has collection only');
        }

        return $this->getActualRecursively($this->rowData);
    }

    /**
     * @param array $response
     * @return bool
     */
    public function isCollectionWhichDoesNotHaveHash($response)
    {
        if (! $this->isCollection($response)) {
            return false;
        }

        foreach (array_values($response) as $responseVal) {
            if (is_array($responseVal) && ! $this->isCollection($responseVal)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $response
     * @return Actual
     */
    private function getActualRecursively($response)
    {
        $actual = new Actual();
        foreach ($response as $key => $val) {
            is_array($val) ? $actual->push($key, $this->getActualRecursively($val)) : $actual->push($key);
        }

        return $actual;
    }

    /**
     * @param $array
     * @return bool
     */
    private function isCollection($array)
    {
        $keys = array_keys($array);
        for ($i = 0; $i < count($keys); $i++) {
            if (! is_numeric($keys[$i])) {
                return false;
            }

            // check key integer sequential
            if (isset($keys[$i + 1]) && $keys[$i] + 1 != $keys[$i + 1]) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $array
     * @return Actual
     */
    private function compress($array)
    {
        if (count($array) == 1) {
            return new Actual($array);
        }

        // よく考えたら潰しちゃいけない・・・
        for ($i = 0; $i < count($array) - 2; $i ++) {
        }

        return new Actual($array[0]);
    }
}
