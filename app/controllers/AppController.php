<?php

namespace app\controllers;

use fm\core\base\Controller;
use fm\core\App;
use fm\core\base\Lang;
use fm\widgets\language\Language;

class AppController extends Controller
{
    public object $app; // базовый класс приложения (глобальный)
    public object $model; // модель
    public array $meta = []; // метаданные
    //public string $layout; // шаблон
    public object $db; // соединение с БД (базовые общие методы)
    
    public function __construct($route, $layout = '') {
        $this->app = App::getInstance(); // базовый класс приложения
        parent::__construct($route);
        $this->db = \fm\core\Db::getInstance();
        // Помещаем в контейнер приложения (в свойство languages) массив языков (получаем из БД)
        $this->app::$registry->setProperty('langs', Language::getLanguages("language"));
        // Помещаем в контейнер (в свойство lang) язык по умолчанию
        $this->app::$registry->setProperty('lang', Language::getLanguage($this->app::$registry->getProperty('langs')));
        // получаю языковые фразы, если существуют для текущего проекта / шаблона
        Lang::load(App::$registry->getProperty('lang'));
    }



    
}