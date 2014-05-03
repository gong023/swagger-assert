<?php

namespace SwaggerAssert;

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
     * @return array
     */
    public function getKeys()
    {
        return $this->getKeysRecursively($this->rowData);
    }

    /**
     * @param array $response
     * @return array
     */
    private function getKeysRecursively($response)
    {
        $result = [];
        foreach ($response as $key => $val) {
            is_array($val) ? $result[$key] = $this->getKeysRecursively($val) : $result[] = $key;
        }

        return $result;
    }
}
