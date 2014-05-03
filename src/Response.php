<?php

namespace SwaggerAssert;

use SwaggerAssert\Container\Actual;

/**
 * Class Response
 */
class Response
{
    /** var array $rowData */
    private $rowData;

    public function __construct(Array $rowData)
    {
        $this->rowData = $rowData;
    }

    /**
     * APIレスポンスの配列より、アサーションすべきkeyの配列を取得する
     *
     * @return Actual
     */
    public function parse()
    {
        return $this->parseRecursively($this->rowData);
    }

    /**
     * @param array $response
     * @return Actual
     */
    private function parseRecursively($response)
    {
        $actual = new Actual();
        foreach ($response as $key => $val) {
            is_array($val) ? $actual->push($key, $this->parseRecursively($val)) : $actual->push($key);
        }

        return $actual;
    }
}
