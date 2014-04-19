<?php

namespace SwaggerAssert;

use \Swagger\Swagger;
use SwaggerAssert\Assertion;

class Annotation
{
    /** @var array result analyzed by swagger */
    public static $analyzedData = null;

    /**
     * swaggerを擬似的に実行する。解析結果はファイルに出力せずオブジェクトに保持させる。
     *
     * @param string $basePath
     */
    public static function analyze($basePath)
    {
        $swagger = new \Swagger\Swagger([$basePath], []);

        $resourceOptions = [
            'output' => 'json',
            'defaultBasePath' => 'dummy string',
            'defaultApiVersion' => null,
            'defaultSwaggerVersion' => '1.2'
        ];

        foreach ($swagger->getResourceNames() as $resourceName) {
            $annotatedData = json_decode($swagger->getResource($resourceName, $resourceOptions), true);
            $resourceName = str_replace('/', '-', ltrim($resourceName, '/'));
            $analyzedData[$resourceName] = $annotatedData;
        }

        self::$analyzedData = $analyzedData;
    }

    /**
     *
     */
    public static function responseHasSwaggerKeys(Array $response, $httpMethod, $url, $onlyRequired = true)
    {
        $assert = new Assertion();
        return $assert->swaggerWithResponse(self::$analyzedData, $response, $httpMethod, $url, $onlyRequired);
    }
}

