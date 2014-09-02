<?php

namespace SwaggerAssert;

use Swagger\Swagger;
use SwaggerAssert\Annotation;
use SwaggerAssert\Compare\CompareResponseAndAnnotation;
use SwaggerAssert\Pick\PickResponseAndAnnotation;

/**
 * Class SwaggerAssert
 */
class SwaggerAssert
{
    /**
     * @var string
     */
    const CACHE_FILE = '/tmp/swagger.json';

    /**
     * @var array $analyzedData
     */
    private static $analyzedData;

    /**
     * emulate swagger. save analyzed data to object
     *
     * @param string $basePath
     */
    public static function analyze($basePath)
    {
        if (isset(self::$analyzedData)) {
            return;
        }
        if (isset($_ENV['swagger-assert-cache']) && $_ENV['swagger-assert-cache'] && file_exists(self::CACHE_FILE)) {
            self::$analyzedData = json_decode(file_get_contents(self::CACHE_FILE), true);
            return;
        }

        $swagger = new Swagger([$basePath], []);

        $resourceOptions = [
            'output' => 'json',
            'defaultBasePath' => 'dummy string',
            'defaultApiVersion' => null,
            'defaultSwaggerVersion' => '1.2'
        ];

        $analyzedData = [];
        foreach ($swagger->getResourceNames() as $resourceName) {
            $annotatedData = json_decode($swagger->getResource($resourceName, $resourceOptions), true);
            $resourceName = str_replace('/', '-', ltrim($resourceName, '/'));
            $analyzedData[$resourceName] = $annotatedData;
        }

        if (isset($_ENV['swagger-assert-cache']) && $_ENV['swagger-assert-cache']) {
            file_put_contents(self::CACHE_FILE, json_encode($analyzedData));
        }
        self::$analyzedData = $analyzedData;
    }

    /**
     * @param array $response
     * @param string $httpMethod
     * @param string $url
     * @param bool $onlyRequired
     * @return bool
     */
    public static function responseHasSwaggerKeys($response, $httpMethod, $url, $onlyRequired = true)
    {
        $responseToCompare = new Response($response);
        $annotation = new Annotation($httpMethod, $url, self::$analyzedData, $onlyRequired);
        $pick = new PickResponseAndAnnotation($responseToCompare, $annotation);
        $compare = new CompareResponseAndAnnotation($pick);

        return $compare->execute();
    }
}
