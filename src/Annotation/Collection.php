<?php

namespace SwaggerAssert\Annotation;

/**
 * Class Collection
 */
class Collection
{
    /**
     * search collections by $key and $val, return bool
     *
     * @param string $key
     * @param string $val
     * @return bool
     */
    public function exists($key, $val)
    {
        foreach ($this->collections as $collection) {
            if (call_user_func_array([$collection, $key], []) == $val) {
                return true;
            }
        }

        return false;
    }

    /**
     * search collections by $key and $val, return instance
     *
     * @param string $key
     * @param string $val
     * @return mixed
     */
    public function pick($key, $val)
    {
        foreach ($this->collections as $collection) {
            if (call_user_func_array([$collection, $key], []) == $val) {
                return $collection;
            }
        }
    }
}
