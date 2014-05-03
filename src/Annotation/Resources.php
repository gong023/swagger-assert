<?php

namespace SwaggerAssert\Annotation;

use SwaggerAssert\Annotation\Resources\Resource;
use SwaggerAssert\Exception\AnnotationException;

/**
 * deal all files of swagger result
 *
 * Class Resources
 * @package SwaggerAssert\Annotation
 */
class Resources extends Collection
{
    /** @var array $collections */
    protected $collections;

    /**
     * コンストラクタ
     *
     * @param array $rowData
     */
    public function __construct($rowData)
    {
        foreach ($rowData as $fileName => $dataVal) {
            $this->collections[] = new Resource($fileName, $dataVal);
        }
    }

    /**
     * httpMethodとurlからassertに使用すべきkeyの配列を取得する
     * onlyRequiredにfalseを渡すと必須パラメーターでないkeyも含めて返す
     *
     * @param string $httpMethod
     * @param string $url
     * @param bool $onlyRequired
     * @return array
     * @throws AnnotationException
     */
    public function expectedKeys($httpMethod, $url, $onlyRequired)
    {
        foreach ($this->collections as $resource) {
            if (! $resource->apis()->exists('path', $url)) {
                continue;
            }
            $operation = $this->pickOperation($resource->apis()->pickAll('path', $url), $httpMethod);
            if (! $operation) {
                continue;
            }

            $keys = $this->pickExpectedKeysRecursively($resource->models(), $operation, $onlyRequired);
            if ($keys !== false) {
                return $keys;
            }
        }

        $message = "SWG\\Model not found. you must write SWG\\Operation TYPE and SWG\\Model ID correctly, or use \$ref key. httpMethod:$httpMethod url:$url";
        throw new AnnotationException($message);
    }

    /**
     * Apiクラスの配列を走破し、指定されたHTTPメソッドに一致したOperationクラスを返す
     * 見つからなかった場合falseを返す
     *
     * @param array $apis
     * @param string $httpMethod
     * @return \SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation|false
     */
    private function pickOperation($apis, $httpMethod)
    {
        foreach ($apis as $api) {
            if (! $api->operations()->exists('method', $httpMethod)) {
                continue;
            }

            return $api->operations()->pick('method', $httpMethod);
        }

        return false;
    }

    /**
     * @param \SwaggerAssert\Annotation\Resources\Resource\Models $models
     * @param \SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation $operation
     * @param bool $onlyRequired
     * @return array|bool
     */
    private function pickExpectedKeysRecursively($models, $operation, $onlyRequired)
    {
        // API structure is list
        if ($operation->hasItemsRef()) {
            return $models->expectedKeys($operation->itemsRef(), $onlyRequired);
        }

        // API structure is hash
        if ($models->exists('id', $operation->type())) {
            $keys = $models->expectedKeys($operation->type(), $onlyRequired);
            // hash has list
            if ($operation->hasItemsRef()) {
                $keys[$operation->itemsRef()] = $this->pickExpectedKeysRecursively($models, $operation, $onlyRequired);
            }

            return $keys;
        }

        return false;
    }
}
