<?php

namespace app\controllers;
use app\models\Test;
use fm\core\App;
use fm\core\base\Lang;
use fm\core\base\View;
use fm\core\Collector;
use fm\core\Registry;
use fm\widgets\language\Language;
use fm\widgets\pagination\Pagination;

// тестирование библиотеки Monolog
use Monolog\Logger;
use Monolog\Handler\StreamHandler;



class TestController extends AppController
{   
    // переопределение шаблона для всех экшенов
    //public string $layout = 'test';
   public function __construct($route) {
       if(!DEBUG) redirect('/');
       parent::__construct($route);
       $this->model = new Test();
       // ЗАДАЮ ШАБЛОН
       $this->layout = "blog";
       // ПОДГРУЖАЮ ЯЗЫКОВЫЕ ФАЙЛЫ
       Lang::load(App::$registry->getProperty('lang'), $this->layout);
   }
    
    public function indexAction(){
       //$menu = $this->model->db->findAll('category');
       // установка метаданных
       View::setMeta('title', 'desc', 'keywords');
     
       // пример кеширования меню
       //$this->app->cache->set('menu', $menu);
       
       // Пытаюсь получить посты из кеша
//       $posts = $this->app->cache->get('posts');
//       if(!$posts){ // если данные не получены, получаем, сохраняем в кеш
//           //$posts = $this->model->db->loadAll('posts', ['2','3']);
//           //$this->app->cache->set('posts', $posts);
//
//       }

        // ПРИМЕР РАБОТЫ С КЕШЕМ (ПОЛУЧЕНИЕ ПОСТОВ)
        /**
         * $posts = $this->app->cache->get('posts');
        if(empty($posts)){
        $posts = $this->model->db->findAll('posts');
        if(!empty($posts)){
        $this->app->cache->set($posts, 'posts');
        }
        }else{
        dump($posts, true);
        }
         */





        // РЕАЛИЗАЦИЯ ПАГИНАЦИИ
        // получаю общее количество записей
        $totalRecords = $this->model->db->count('posts');
        // получаю номер текущей страницы для вывода
        $page = isset($_GET["page"]) ? (int)$_GET['page'] : 1;
        // устанавливаю количество записей для вывода на одной странице
        $perpage = 2;
        // создаю объект (будет сформирован html код пагинации)
        $pagination = new Pagination($page, $perpage, $totalRecords);


        // определяю с какой записи начать делать выборку
        $start = $pagination->getStart();

        // получаем только посты для текущей страницы
        $posts = $this->model->db->findAll('posts', "LIMIT $start, $perpage");


       $this->set(compact('posts', 'pagination'));
       
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

       $collector = new Collector();
       $files = $collector->getFiles();
       dump($files);
        
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

    public function formAction(){
       if($this->isAjax()){
           echo "ajax пришел";
       }else{
           echo "not ajax";
       }
       $this->layout = false;
       $this->view = false;
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

    public function tableAction(){
       $model = new Test();
       $lang = $model->db->dispense('language');
       $lang->code = 'en';
       $lang->title = 'Eng';
       $lang->base = 0;
       //$res = $model->db->store($lang);

       //dump($res, true);
        $this->layout = false;
        $this->view = false;
    }


}