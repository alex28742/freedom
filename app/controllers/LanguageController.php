<?php

namespace app\controllers;

class LanguageController extends AppController
{
    public function changeAction(){
        $lang = !empty($_GET['lang']) ? $_GET['lang'] : null;
        if($lang){
            // проверяем есть ли полученное значение в списке доступных языков
            if(array_key_exists($lang, $this->app::$registry->getProperty('langs'))){
                // для всего домена запоминаем на делелю
                setcookie('lang', $lang, time() + 3600 * 24 * 7, '/');
            }
        }
        redirect();
    }
}