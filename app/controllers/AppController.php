<?php

namespace app\controllers;

use fm\core\base\Controller;
use fm\core\App;

class AppController extends Controller
{
    public object $app; // базовый класс приложения
    public object $model; // модель
    public array $meta = []; // метаданные
    //public string $layout; // шаблон
    public object $db; // соединение с БД (базовые общие методы)
    
    public function __construct($route, $layout = '') {
        $app = new App; // для использования в наследниках (реестр)
        $this->app = $app::$app; // помещаю метод в свойство
        parent::__construct($route);
        $this->db = \fm\core\Db::getInstance();
    }



    
}