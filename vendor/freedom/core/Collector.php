<?php

namespace fm\core;
/**
 * Класс собирающий скрипты и стили и подключающий их в layout
 */

class Collector
{
    public string $extention = ".js"; // тип файла по-умолчанию (расширение)
    private string $path = "/assets/"; // путь для сохранения файлов по-умолчанию
    private string $name; // уникальный ключ (строка / название)


    /** Метод для смены расширения файла и пути хранения файлов по-умолчанию
     * @param string $name название файла которое будет использоваться как идентификатор
     * @param string $type строка вида "txt" или "js" и пр.
     * @param string $path путь хранения файлов кеша
     * @return void
     */
    public function settings(string $name, string $type = "js", string $path = ""){

        $this->name = $name;
        $this->extention = "." . $type;
        if(is_dir(WWW . $path)){
            $this->path = $path;
        }else{
            throw new \Exception("Путь к директории хранения файла указан не корректно");
        }

    }

    /**
     * Запись данных в файл
     * @param string $key
     * @param mix $data
     * @param time $time
     * @return boolean
     */
    public function createFile($data, $name = ""){
        if(!isset($this->name)){
            $this->name = $name;
        }
        // создаем файл
        if(!file_put_contents(WWW . $this->path . $this->name . $this->extention, $data)){
            throw new \Exception("Can't create cache file in " . $this->path);
        }
        return true;
    }



    /** Получение пути к файлу кеша
     * @param bool $flag если передан флаг true - вернет относительный путь от корня, прим - /tmp/... false вернет полный путь, типа /var/www/domen/...,
     * @return string
     */
    public function getPath(bool $flag = true){
        if($flag){ // вернуть относительный путь
            return $this->path . $this->name . $this->extention;
        }
        // вернет полный путь
        return WWW . $this->path . $this->name . $this->extention;
    }



    /** Получаю содержимое файлов JS
     * @param array $files Массив файлов js
     * @return string Данные из файлов
     */
    public function getJSdata($files = []){
        $data = "";
        foreach ($files as $file){
            if(is_file($file))
                $data .= file_get_contents($file);
        }
        return $data;
    }

    /** Получение массива путей к файлам JS находящимся в корневой директории зарегистрированных объектов
     * @return array
     */
    public function getJSfiles(){
        $files = [];
        // получаю массив зарегистрированных объектов
        $registry = Registry::getInstance();
        $objects = $registry->getObjects();
        foreach ($objects as $object) {
            // получаю предполагаемый путь к файлу
            // нужна эта проверка так как не у всех объектов может быть свойство path
            if(isset($object->path)){
                $file = rtrim($object->path, "/") . "/script.js";
                if(is_file($file)){
                    array_push($files, $file);
                }
            }

        }
        return $files;
    }




}