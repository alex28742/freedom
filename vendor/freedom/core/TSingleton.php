<?php

namespace fm\core;

trait TSingleton
{
    protected static $instance = null;

    /**
     * Если объект не создан - создаем, иначе - возвращаем
     * @return object
     */
    public static function getInstance($args = []):object {
        if(self::$instance === null){
            self::$instance = new self($args);
        }
        return self::$instance;
    }

}