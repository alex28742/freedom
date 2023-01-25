<?php

namespace fm\core;

/**
 * Базовый класс всего приложения
 *
 * @author als
 */
class App {
    
    public static object $app;
    
    public function __construct() {
        self::$app = Registry::getInstance();
    }
    
    
}
