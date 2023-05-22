<?php

namespace fm\core;

/**
 * Базовый класс всего приложения
 *
 * @author als
 */
class App {
    use TSingleton;
    public $cache; // объект кеширования
    public $collector;
    //public $prolog; // путь к файлу пролога (для вывода css ядра)

    public static object $registry; // Объект в котором собираются и регистрируются объекты и свойства, доступные глобально

    protected function __construct() {
        self::$registry = Registry::getInstance();
        $this->cache = self::$registry->cache;
        $this->collector = self::$registry->collector;
    }

    /** Подключение файла эпилога
     * @return void
     * @throws \Exception
     */
    public function getEpilog(){
        if(is_file(CORE . "/inc/epilog.php"))
            require_once CORE . "/inc/epilog.php";
        else throw new \Exception("Не найден файл эпилога");
    }

    /** Подключение файла пролога
     * @return void
     * @throws \Exception
     */
    public function getProlog(){
        if(is_file(CORE . "/inc/prolog.php"))
            require_once CORE . "/inc/prolog.php";
        else throw new \Exception("Не найден файл пролога");
    }

    /** Метод выводящий скрипты объектов, виджетов перед закрывающей body (в epilog.php)
     * @return void
     */
    public function IncludeJS(){
        // определяю где будет находится общий файл, название, расширение
        $this->collector->settings("widgets", "js", "/assets/js/");
        // получаю список всех файлов скриптов, найденных в виджетах
        $files = $this->collector->getJSfiles();
        // получаю все данные из файлов
        $data = $this->collector->getJSdata($files);
        // создаю общий файл скриптов
        $this->collector->createFile($data);
        // получаю путь к файлу
        $path = $this->collector->getPath();

        echo "<script src='{$path}'></script>";
    }


    
    
}
