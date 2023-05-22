<?php

namespace fm\core;

/**
 * Класс регистр объектов приложения и хранения свойство (properties) доступных глобально
 * Базовый класс ядра App получает экземпляр данного класса в конструкторе и становится доступен глобально, т.к. вызывается в файле - точке входа (public/index.php)
 * Экземпляр класса App ($app) является контейнером классов, созданных на основе данных из app/config/config.php и помещенных в контейнер.
 * Пример вызова класса кеширования в контроллере: $this->app->cache->set('menu', $menu); где $this - экз. текущего контроллера, app - объект класса приложения App, cache - Класс кеширования, set - метод этого класса.
 * В произвольном месте приложения, вызов данного класса \fm\core\App::$app->
 *
 * @author als
 */
class Registry {
    use TSingleton; // реализован метод getInstance()
    public $config = [];
    protected static $objects; // контейнер для хранения объектов
    protected static $properties = []; // контейнер для хранения произвольных свойств (конфигов и пр.)
    public $scripts = []; // скрипты приложения подключаемые в эпилоге (частично инициализируется в Виде)
    public $widgets = []; // массив имен объектов виджетов (зарегистрированных, т.е. используемых системой)
    
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

    /** Произвольное добавление объектов (ссылок) в контейнер доступный глобально
     * @param $name
     * @param $object
     * @return void
     */
    public function addObject($name, $object){
        if(is_object($object)){
            self::$objects[$name] =  $object;
        }
    }

    /** Получение массива объектов хранящихся в контейнере
     * @return mixed
     */
    public function getObjects(){
        return self::$objects;
    }

    /** Запись свойств в контейнер
     * @param $name
     * @param $value
     * @return void
     */
    public function setProperty($name, $value){
        self::$properties[$name] = $value;
    }

    /** Получение свойства по его наименованию
     * @param $name
     * @return mixed|null
     */
    public function getProperty($name){
        return isset(self::$properties[$name]) ? self::$properties[$name] : null;
    }

    /**
     * Распечатка всех свойств в контейнере
     */
    public function printProperties(){
        echo "<pre>";
        var_dump(self::$properties);
        echo "</pre>";
    }
    
    /**
     * Распечатка всех объектов в контейнере
     */
    public function printObjects(){
        echo "<pre>";
        var_dump(self::$objects);
        echo "</pre>";
    }
}
