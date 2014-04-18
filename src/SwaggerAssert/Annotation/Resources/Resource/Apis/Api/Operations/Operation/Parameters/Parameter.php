<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters;

/**
 * SWG\Parameterのクラス
 *
 * Class Parameter
 * @package SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters
 */
class Parameter
{
    /** @var array $parameter */
    private $parameter;

    /**
     * @param array $parameter
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->parameter['description'];
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->parameter['name'];
    }

    /**
     * @return string
     */
    public function paramType()
    {
        return $this->parameter['paramType'];
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->parameter['type'];
    }
}
