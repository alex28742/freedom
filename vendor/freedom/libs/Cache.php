<?php

namespace fm\libs;

/**
 * Класс кеширования
 * 1) метод который записывает данные в файл
 * 2) метод который считывает данные
 * 3) метод удаления кеша
 *
 * @author als
 */
class Cache {
    
    public function __construct() {
        
    }
    
    /**
     * Запись данных в файл кеша
     * @param string $key
     * @param mix $data
     * @param time $time
     * @return boolean
     */
    public function set($key, $data, $time = 3600){
        // высчитываем конечную дату для кеширования данных (expires)
        $content['data'] = $data;
        $content['expires'] = time() + $time;
        // название файла хэшируем и даем произвольное расширение
        // сериализуем данные перед записью
        if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))){
            return true;
        }
        return false;
    }
    
    /**
     * Получение данных из кеша по ключу
     * @param string $key
     * @return boolean
     */
     public function get($key){
         $file = CACHE . '/' . md5($key) . '.txt';
        // если существует файл - считываем
         if(file_exists($file)){
            $content = unserialize(file_get_contents($file));
            // проверяем expires
            if(time() <= $content['expires']){
                // кеш актуален, возвращаем
                return $content['data'];
            }
            // если данные не актуальны, удаляем файл
            unlink($file);
            return false;
        }
    }
    
    /**
     * Удаление данных по ключу
     * @param type $key
     */
    public function delete($key){
         $file = CACHE . '/' . md5($key) . '.txt';
         if(file_exists($file)){
             unlink($file);
             return true;
         }
         return false;
    }
}
