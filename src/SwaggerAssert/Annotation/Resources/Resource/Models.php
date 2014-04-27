<?php

namespace SwaggerAssert\Annotation\Resources\Resource;

use SwaggerAssert\Annotation;
use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Models\Model;
use SwaggerAssert\Exception\AnnotationException;

/**
 * SWG\Modelをコレクションするクラス
 *
 * Class Models
 * @package SwaggerAssert\Annotation\Resources\Resource
 */
class Models extends Collection
{
    /** @var array $collections */
    protected $collections = [];

    /**
     * コンストラクタ
     *
     * @param array $resources
     */
    public function __construct($resources)
    {
        foreach ($resources as $resource) {
            $this->collections[] = new Model($resource);
        }
    }

    /**
     * modelIdからアサーションに必要なkeyの配列を返す
     *
     * @param string $modelId
     * @param bool $onlyRequired
     * @return array
     * @throws AnnotationException
     */
    public function expectedKeys($modelId, $onlyRequired)
    {
        if (! $this->exists('id', $modelId)) {
            $url = Annotation::$url;
            $httpMethod = Annotation::$httpMethod;
            throw new AnnotationException("specified SWG\\Model is not written in your doc. httpMethod: $httpMethod, url: $url, modelId: $modelId");
        }

        $values = [];
        foreach ($this->pick('id', $modelId)->properties($onlyRequired)->getCollection() as $property) {
            $values = array_merge($values, $this->referencedKeys($property, $onlyRequired));
        }

        return $values;
    }

    /**
     * Propertyが参照しているModelのkey一覧を返す
     * この関数はexpectedKeysWithNotOnlyRequireから再度呼び出されており、擬似的な再帰になっている
     * 循環参照のように見えるが必ず返り値があるので大丈夫
     *
     * @param \SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties\Property $property
     * @param bool $onlyRequired
     * @return array
     */
    public function referencedKeys($property, $onlyRequired)
    {
        if ($property->hasRef()) {
            $refModelId = $property->refModelId();
            $values = $this->expectedKeys($refModelId, $onlyRequired);
            return [$property->key() => $values];
        }

        return [$property->key()];
    }
}
