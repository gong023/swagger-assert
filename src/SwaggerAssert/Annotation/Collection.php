<?php

namespace SwaggerAssert\Annotation;

/**
 * Class Collection
 */
class Collection
{
    /**
     * コレクションしたクラスを$keyと$valで検索し、存在するかどうかをboolで返す
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
     * コレクションしたクラスを$keyと$valで検索し、一致したクラスのインスタンスを返す
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
