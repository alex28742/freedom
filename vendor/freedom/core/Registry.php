<?php

namespace fm\core;

/**
 * Класс регистр объектов приложения.
 *
 * @author als
 */
class Registry {
    use TSingleton; // реализован метод getInstance()
    public $config = [];
    protected static $objects; // контейнер для хранения объектов
    
    // приватный конструктор, т.к. используется singleton
    private function __construct() {
        $this->config = require ROOT . '/config/config.php';
        $this->init(); // создание объектов полученных из массива config
    }
    
    private function init() {
        
        
        if(!empty($this->config["components"])){
            foreach ($this->config["components"] as $name => $component){
                self::$objects[$name] = new $component;               
            }
        }
    }
    
    
    /**
     * Магический метод получения незарегистрированного объекта
     * @param string $name
     * @return object || null
     */
    public function __get($name) {
        if(is_object(self::$objects[$name])){
            return self::$objects[$name];
        }
    }
    
    /**
     * Маг. метод добавления новых объектов в контейнер
     * @param type $name
     * @param type $object
     */
    public function __set($name, $object) {
        // если такого объекта еще нет
        if(!isset(self::$objects[$name])){
            self::$objects[$name] = new $object;
        }
    }
    
    /**
     * Распечатка всех объектов в контейнере
     */
    public function printList(){
        echo "<pre>";
        var_dump(self::$objects);
        echo "</pre>";
    }
}
