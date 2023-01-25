<?php
namespace app\controllers;
use fm\core\base\View;

class MainController extends AppController
{

    public function indexAction():void{
        echo __METHOD__ . "</br>";
        View::setMeta('Главная', 'Описание', 'Ключевики');

    }
    

}