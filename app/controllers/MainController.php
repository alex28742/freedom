<?php
namespace app\controllers;
use fm\core\base\View;

class MainController extends AppController
{

    public function indexAction():void{
        echo "<code>" . __METHOD__ . "</code></br>";
        View::setMeta('Персональный блог', 'Описание', 'Ключевики');

    }
    

}