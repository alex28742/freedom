<?php

class Helper
{
    /**
     * Распечатка данных
     * @param $data // данные для распечатки
     * @param $die // завершить отработку кода
     * @param $type // true - var_dump, false = print_r (default) опционально
     * @return void
     */
    public static function dump($data, bool $die = false, bool $type = false):void{
        echo "<pre>"; if(!$type) var_dump($data); else print_r($data);
        echo "</pre>"; if($die) die();
    }
}