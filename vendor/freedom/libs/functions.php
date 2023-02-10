<?php
    function dump($data, bool $die = false, bool $type = true):void{
        echo "<pre>"; if(!$type) var_dump($data); else print_r($data);
        echo "</pre>"; if($die) die();
    }
    
    function debug($data, bool $die = false, bool $type = true):void{
        dump($data, $die, $type);
    }

/**
 * Функция редитекта
 * @param $url страница на которую надо отредиректить, если не передана, возврат на предыдущую
 * @return void
 */
    function redirect($url = false){
        if($url){
            $redirect = $url;
        }else{
            // возвращаем на предыдущую страницу если существует, либо на главную
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        }
        header("Location: $redirect");
        exit;
    }

/** Преобразование (обработка) специальных символов
 * @param $str
 * @return string
 */
    function h($str){
        return htmlspecialchars($str, ENT_QUOTES);
    }

