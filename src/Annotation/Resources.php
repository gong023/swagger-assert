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
     * @return \SwaggerAssert\Container\Expected
     * @throws AnnotationException
     */
    public function expected($httpMethod, $url, $onlyRequired)
    {
        /* @var \SwaggerAssert\Annotation\Resources\Resource $resource */
        foreach ($this->collections as $resource) {
            if (! $resource->apis()->exists('path', $url)) {
                continue;
            }
            $operation = $this->pickOperation($resource->apis()->pickAll('path', $url), $httpMethod);
            if (! $operation) {
                continue;
            }

            $expected = $this->pickExpectedRecursively($resource->models(), $operation, $onlyRequired);
            if ($expected !== false) {
                return $expected;
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
        /* @var \SwaggerAssert\Annotation\Resources\Resource\Apis\Api $api */
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
     * @return \SwaggerAssert\Container\Expected|bool
     */
    private function pickExpectedRecursively($models, $operation, $onlyRequired)
    {
        // API structure is list
        if ($operation->hasItemsRef()) {
            return $models->buildExpectedByModelId($operation->itemsRef(), $onlyRequired);
        }

        // API structure is hash
        if ($models->exists('id', $operation->type())) {
            $expected = $models->buildExpectedByModelId($operation->type(), $onlyRequired);
            // hash has list
            /* no longer needed?
            if ($operation->hasItemsRef()) {
                $expected[$operation->itemsRef()] = $this->pickExpectedRecursively($models, $operation, $onlyRequired);
            }
            */

            return $expected;
        }

        return false;
    }
}
