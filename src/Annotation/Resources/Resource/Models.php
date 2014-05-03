<?php

namespace SwaggerAssert\Annotation\Resources\Resource;

use SwaggerAssert\Annotation;
use SwaggerAssert\Container\Expected;
use SwaggerAssert\Annotation\Collection;
use SwaggerAssert\Annotation\Resources\Resource\Models\Model;
use SwaggerAssert\Exception\AnnotationException;

/**
 * collection of SWG\Model
 *
 * Class Models
 */
class Models extends Collection
{
    /** @var array $collections */
    protected $collections = [];

    /**
     * @param array $resources
     */
    public function __construct($resources)
    {
        foreach ($resources as $resource) {
            $this->collections[] = new Model($resource);
        }
    }

    /**
     * build instance of Expected by $modelId
     *
     * @param string $modelId
     * @param bool $onlyRequired
     * @return Expected
     * @throws AnnotationException
     */
    public function buildExpectedByModelId($modelId, $onlyRequired)
    {
        if (! $this->exists('id', $modelId)) {
            $url = Annotation::$url;
            $httpMethod = Annotation::$httpMethod;
            throw new AnnotationException("specified SWG\\Model is not written in your doc. httpMethod: $httpMethod, url: $url, modelId: $modelId");
        }

        $expected = new Expected();
        foreach ($this->pick('id', $modelId)->properties($onlyRequired)->getCollection() as $property) {
            /** @var $property \SwaggerAssert\Annotation\Resources\Resource\Models\Model\Properties\Property */
            if ($property->hasRef()) {
                $expected->push($property->key(), $this->buildExpectedByModelId($property->refModelId(), $onlyRequired));
                continue;
            }

            $expected->push($property->key());
        }

        return $expected;
    }
}
