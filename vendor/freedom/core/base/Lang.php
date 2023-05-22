<?php

namespace fm\core\base;

class Lang
{
    public static $data = []; // переводные фразы
    public static $tpl = ""; // шаблон приложения

    /** Собираем языковые фразы в статичное свойство
     * @param $code
     * @return void
     */
    public static function load($code, $tpl = ""){
         if($tpl === "") $tpl = LAYOUT;
         //$tpl = $tpl;
        $file = APP . "/layouts/{$tpl}/langs/{$code['code']}.php";
        if(file_exists($file)){
            self::$data = require $file;
        }
        dump(self::$data);
    }


    /** Возвращает языковую фразу по ключу
     * @param $key
     * @return array
     */
    public static function get($key){
        return self::$data[$key] ?: [];
    }

}