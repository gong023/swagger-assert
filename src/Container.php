<?php
namespace SwaggerAssert;

/**
 * Class Container
 * php array is not useful because assoc and hash are mixed
 */
class Container
{
    /**
     * @param null|string $name
     * @param null $value
     */
    public function __construct($name = null, $value = null)
    {
        if (! is_null($name)) {
            $this->push($name, $value);
        }
    }

    /**
     * @param string $name
     * @param self $value
     */
    public function push($name, self $value = null)
    {
        $this->$name = $value;
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys(get_object_vars($this));
    }

    /**
     * @return array
     */
    public function references()
    {
        $values = [];
        foreach ($this->keys() as $key) {
            if (! is_null($this->$key)) {
                $values[] = $this->$key;
            }
        }

        return $values;
    }
}