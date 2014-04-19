<?php

namespace SwaggerAssert\Annotation\Resources\Resource\Apis\Api\Operations\Operation\Parameters;

use SwaggerAssert\Annotation\Individual;

/**
 * SWG\Parameterのクラス
 */
class Parameter extends Individual
{
    /**
     * @return string
     */
    public function description()
    {
        return $this->written('description');
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->written('name');
    }

    /**
     * @return string
     */
    public function paramType()
    {
        return $this->written('paramType');
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->written('type');
    }
}
