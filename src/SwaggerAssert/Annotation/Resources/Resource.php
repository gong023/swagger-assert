<?php

namespace SwaggerAssert\Annotation\Resources;

use SwaggerAssert\Annotation\Individual;
use SwaggerAssert\Annotation\Resources\Resource\Apis;
use SwaggerAssert\Annotation\Resources\Resource\Models;

/**
 * SWG\Resourceのクラス
 */
class Resource extends Individual
{
    /** @var string $fileName */
    private $fileName;

    /**
     * コンストラクタ
     *
     * @param string $fileName
     * @param array $resource
     */
    public function __construct($fileName, $resource)
    {
        $this->fileName = $fileName;
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function fileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function basePath()
    {
        return $this->resource['basePath'];
    }

    /**
     * @return string
     */
    public function resourcePath()
    {
        return $this->resource['resourcePath'];
    }

    /**
     * @return string
     */
    public function swaggerVersion()
    {
        return $this->resource['swaggerVersion'];
    }

    /**
     * @return Apis
     */
    public function apis()
    {
        return new Apis($this->written('apis'));
    }

    /**
     * @return Models
     */
    public function models()
    {
        return new Models($this->written('models'));
    }
}
