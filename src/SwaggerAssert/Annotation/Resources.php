<?php

namespace SwaggerAssert\Annotation;

use SwaggerAssert\Annotation\Resources\Resource;

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

            // APIレスポンスにコレクションが想定されている場合
            if ($operation->hasItemsRef()) {
                return $resource->models()->expectedKeys($operation->itemsRef(), $onlyRequired);
            }

            // APIレスポンスにオブジェクトが想定されている場合
            if ($resource->models()->exists('id', $operation->type())) {
                return $resource->models()->expectedKeys($operation->type(), $onlyRequired);
            }
        }

        //TODO:例外投げる
    }

    /**
     * Apiクラスの配列を走破し、指定されたHTTPメソッドに一致したOperationクラスを返す
     * 見つからなかった場合falseを返す
     *
     * @param array $apis
     * @param string $httpMethod
     * @return Operation|bool
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
}
