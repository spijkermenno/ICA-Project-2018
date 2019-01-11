<?php

namespace App;

use ArrayAccess;
use Illuminate\Contracts\Support\Jsonable;

abstract class ORMLessModel implements ArrayAccess, Jsonable
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function offsetExists($offset): bool
    {
        if (is_array($this->data)) {
            return isset($this->data[$offset]);
        }
        return isset($this->data->{$offset});
    }

    public function offsetGet($offset)
    {
        return data_get($this->data, $offset);
    }

    public function offsetSet($offset, $value)
    {
        data_set($this->data, $offset, $value);
    }

    public function offsetUnset($offset)
    {
        if (is_array($this->data)) {
            unset($this->data[$offset]);
        } elseif (is_object($this->data)) {
            unset($this->data->{$offset});
        }
    }

    public function __get($offset)
    {
        return $this->offsetGet($offset);
    }

    public function __set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->data, $options);
    }
}
