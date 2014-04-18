<?php

namespace SwaggerAssert\Annotation\Resources;

use SwaggerAssert\Annotation\Resources\Resource\Apis;
use SwaggerAssert\Annotation\Resources\Resource\Models;

/**
 * SWG\Resourceのクラス
 *
 * Class Resource
 * @package SwaggerAssert\Annotation\Resources
 */
class Resource
{
    /** @var string $fileName */
    private $fileName;

    /** @var array $resources */
    private $resources;

    /**
     * コンストラクタ
     *
     * @param string $fileName
     * @param array $resources
     */
    public function __construct($fileName, $resources)
    {
        $this->fileName = $fileName;
        $this->resources = $resources;
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
        return $this->resources['basePath'];
    }

    /**
     * @return string
     */
    public function resourcePath()
    {
        return $this->resources['resourcePath'];
    }

    /**
     * @return string
     */
    public function swaggerVersion()
    {
        return $this->resources['swaggerVersion'];
    }

    /**
     * @return Apis
     */
    public function apis()
    {
        return new Apis($this->resources['apis']);
    }

    /**
     * @return Models
     */
    public function models()
    {
        return new Models($this->resources['models']);
    }
}
