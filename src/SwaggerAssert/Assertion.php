<?php

namespace SwaggerAssert;

use SwaggerAssert\Annotation\Resources;

class Assertion
{
    /**
     * @param array $analyzedData
     * @param array $response
     * @param string $httpMethod
     * @param string $url
     * @param bool $onlyRequired
     * @return array
     */
    public function swaggerWithResponse($analyzedData, $response, $httpMethod, $url, $onlyRequired = true)
    {
        $isAssoc = (bool)count(array_filter(array_keys($response), 'is_string'));

        try {
            $expectedKeys = $this->expectedKeys($analyzedData, $httpMethod, $url, $onlyRequired);
            $actualKeys   = $this->actualKeys($response);
        } catch (\Exception $e) {
            return ['isSuccess' => false, 'failMessage' => $e->getMessage()];
        }

        $isSuccess = $this->compare($expectedKeys, $actualKeys, $isAssoc);

        return [
            'isSuccess'   => $isSuccess,
            'failMessage' => $this->failMessage($actualKeys, $expectedKeys)
        ];
    }

    /**
     * httpMethodとurlから取り出したmodelより、所持すべきkeyの配列を取得する
     *
     * @param array $analyzedData
     * @param string $httpMethod
     * @param string $url
     * @param bool $onlyRequired
     * @return array
     */
    public function expectedKeys($analyzedData, $httpMethod, $url, $onlyRequired)
    {
        $resources = new Resources($analyzedData);
        $keys = $resources->expectedKeys($httpMethod, $url, $onlyRequired);
        $this->readableSort($keys);

        return $keys;
    }

    /**
     * APIレスポンスの配列より、アサーションすべきkeyの配列を取得する
     *
     * @param array $response
     * @return array
     */
    public function actualKeys($response)
    {
        $result = [];
        foreach ($response as $key => $val) {
            if (is_array($val)) {
                $result[$key] = $this->actualKeys($val);
            } else {
                $result[] = $key;
            }
        }

        return $result;
    }

    /**
     * @param array $expectedKeys
     * @param array $actualKeys
     * @param bool $isAssoc
     * @return bool
     */
    public function compare($expectedKeys, $actualKeys, $isAssoc)
    {
        if ($isAssoc) {
            return ($expectedKeys === $actualKeys);
        }

        foreach ($actualKeys as $actual) {
            if ($actual !== $expectedKeys) {
                return false;
            }
        }

        return true;
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

    /**
     * @param array $actualKeys
     * @param array $expectedKeys
     * @return string
     */
    private function failMessage($actualKeys, $expectedKeys)
    {
        $message = 'Failed asserting that API response and swagger document are equal.' . PHP_EOL;
        $message .= 'response' . var_export($actualKeys, true) . PHP_EOL;
        $message .= 'swagger' . var_export($expectedKeys, true) . PHP_EOL;

        return $message;
    }
}
