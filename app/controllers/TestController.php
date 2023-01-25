<?php

namespace app\controllers;
use app\models\Test;
use fm\core\base\View;

// тестирование библиотеки Monolog
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class TestController extends AppController
{   
    // переопределение шаблона для всех экшенов
    //public string $layout = 'test';
   public function __construct($route) {
       parent::__construct($route);
       $this->model = new Test();
   }
    
    public function indexAction(){
       //$menu = $this->model->db->findAll('category');
       // установка метаданных
       View::setMeta('title', 'desc', 'keywords');
     
       // пример кеширования меню
       //$this->app->cache->set('menu', $menu);
       
       // Пытаюсь получить посты из кеша
       $posts = $this->app->cache->get('posts');
       if(!$posts){ // если данные не получены, получаем, сохраняем в кеш
           $posts = $this->model->db->loadAll('posts', ['2','3']);
           //$this->app->cache->set('posts', $posts);
       }


       $this->set(compact('posts'));
       
    }
    
    
    // тестирование библиотеки Monolog
    public function monologAction(){
        // создаем объект логера
        $log = new Logger('monolog');
        // указываем путь к файлу логов и уровень ошибок для записи
        $log->pushHandler((new StreamHandler(ROOT . '/tmp/monolog.log', Logger::Warning)));
        $this->layout = false;
    }
    
    public function testAction(){
        // пример выполнения ajax запроса
        if($this->isAjax()){
          echo 'is Ajax';
        }else{
          dump($this->model);
        }
        

        // отключаем подключение шаблона
        
        $this->layout = false;
    }
    
    // тестирование получения данных по ajax запросу из вида (готовый html)
    public function ajaxAction(){
        if($this->isAjax()){
            $posts = $this->model->db->loadAll('posts', ['2','3']);
            $this->loadView('test', compact('posts'));
        }
        
        
        $this->layout = false;
    }

    public function index2Action(){
        //echo __METHOD__;
        // переопределение вида внутри экшена
//        $this->view = 'test';
        // переопределение шаблона внутри экшена
        //$this->layout = 'index';

        // передаем переменную в вид c помощью метода контроллера set
        $name = 'Vasya Pupkin';
        $hi = 'Привет';
        $color = [
            'white' => 'Белый',
            'black' => 'Черный',
            'red' => 'Красный'
        ];
        $this->set(compact('name', 'hi', 'color'));
        
        // получаем объект модели (передаю имя таблицы в БД)
        $model = new Test('posts');
        // запрос получения всех постов
        $posts = $model->findAll();
        // получаем вторую запись
        $post = $model->findOne('Тестовый пост', 'title');
        // переопределяем название поля по которому ищем (по-умолч. id)
        $model->pKey = 'category_id';
        // выборка на основании id категории
        $post2 = $model->findOne(2);
        // выборка по произвольному sql запросу
        $sql = "SELECT * FROM {$model->table} ORDER BY id DESC LIMIT 2";
        $posts2 = $model->findBySql($sql);
        
        $sql2 = "SELECT * FROM {$model->table} WHERE title LIKE ?";
        $post3 = $model->findBySql($sql2, ["%то%"]);
        
        $data = $model->findLike('Тест', 'title');
        dump($data, true);
        
        $this->set(compact('posts', 'post', 'post2', 'posts2', 'post3'));

    }


}