<?php

namespace SwaggerAssert;

use Swagger\Swagger;
use SwaggerAssert\Compare\CompareResponseAndAnnotation;
use SwaggerAssert\Response;
use SwaggerAssert\Annotation;

class SwaggerAssert
{
    /** var array $analyzedData */
    private static $analyzedData;

    /**
     * swaggerを擬似的に実行する。解析結果はファイルに出力せずオブジェクトに保持させる。
     *
     * @param string $basePath
     */
    public static function analyze($basePath)
    {
        if (isset(self::$analyzedData)) {
            return;
        }

        $swagger = new Swagger([$basePath], []);

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
     * @param array $response
     * @param string $httpMethod
     * @param string $url
     * @param bool $onlyRequired
     * @return array
     */
    public static function responseHasSwaggerKeys($response, $httpMethod, $url, $onlyRequired = true)
    {
        $responseToCompare = new Response($response);
        $annotation = new Annotation($httpMethod, $url);
        $compare = new CompareResponseAndAnnotation($responseToCompare, $annotation, self::$analyzedData, $onlyRequired);

        return $compare->execute();
    }
}
