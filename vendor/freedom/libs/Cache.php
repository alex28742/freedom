<?php

namespace fm\libs;
    /**
 * Класс кеширования
 * 1) метод который записывает данные в файл
 * 2) метод который считывает данные
 * 3) метод удаления кеша
     *
     * Пример работы с кешем для получения постов в контроллере:
            $posts = $this->app->cache->get('posts'); // попытка получить посты из кеша по ключу
            if(empty($posts)){ // если не получены данные
            $posts = $this->model->db->findAll('posts'); // получаю из БД
            if(!empty($posts)){ // если массив не пуст
                $this->app->cache->set($posts, 'posts'); // добавляю данные в кеш
            }
            }else{
                dump($posts, true); // работа с массивом постов
             }
 *
 * @author als
 */
class Cache {

    public string $extention = ".txt"; // тип файла по-умолчанию (расширение)
    private string $path = CACHE; // путь для сохранения файлов кеша по-умолчанию
    private string $key; // уникальный ключ (строка / название)

    /**
     * Запись данных в файл кеша
     * @param string $key
     * @param mix $data
     * @param time $time
     * @return boolean
     */
    public function set($data, $key, $time = 3600){
        $this->key = md5($key);
        $content['data'] = $data;
        // высчитываем конечную дату для кеширования данных (expires)
        $content['expires'] = time() + $time;
        // название файла хэшируем и даем произвольное расширение
        // сериализуем данные перед записью
        if(!file_put_contents($this->path . '/' . $this->key . $this->extention, serialize($content))){
            throw new \Exception("Can't create cache file in " . $this->path);
        }
        return true;
    }



    /** Получение пути к файлу кеша
     * @param bool $flag если передан флаг true - вернет полный путь от корня, прим - /var/www/domen/..  false вернет относительный путь, типа /tmp/cache/...
     * @return string
     */
    public function path(bool $flag = true){
        $path = rtrim($this->path, "/") . "/" . $this->key . $this->extention;
        if($flag)
            return $path;
        else
            return str_replace(WWW, "", $path);
    }

    /**
     * Получение данных из кеша по ключу
     * @param string $key (уникальный ключ, название файла)
     * @return array  (массив данных, либо пустой массив если данные не получены)
     */
     public function get($key){
         $key = md5($key);
         $file = $this->path . "/" . $key . $this->extention;
        // если существует файл - считываем
         if(file_exists($file)){
             echo "файл существует <br>";
            $content = unserialize(file_get_contents($file));
            // проверяем expires
            if(time() <= $content['expires']){
                // кеш актуален, возвращаем
                return $content['data'];
            }
            // если данные не актуальны, удаляем файл
            unlink($file);
        }
         return [];
    }
    
    /**
     * Удаление данных по ключу
     * @param type $key
     */
    public function delete($key){
         $file = CACHE . '/' . md5($key) . $this->extention;
         if(file_exists($file)){
             unlink($file);
             return true;
         }
         return false;
    }
}
