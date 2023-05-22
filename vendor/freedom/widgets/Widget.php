<?php

namespace fm\widgets;

use fm\core\App;

class Widget
{
    public $tpl; // путь к шаблону (включая файл php)
    public $path; // путь к шаблону (вплоть до директории конкретного шаблона) для подключения файлов скриптов / стилей

    protected function __construct($myself = null)
    {
        // если передан объект для регистрации, регистрируем
        if(isset($myself) && is_object($myself)){
            $app = App::getInstance();
            $name = $this->getClassName($myself);
            $app::$registry->addObject($name, $myself);
        }
    }

    /** Получение имени класса объекта
     * @param $myself
     * @return string
     */
    protected function getClassName($myself){
        $name = get_class($myself);
        $name = ltrim(strrchr($name, '\\'), '\\');
        return $name;
    }

    /** Получение пути к шаблону (инициализация свойств $tpl и $path)
     * @param object$myself объект класса
     * @param string $tpl название шаблона переданное в конструктор
     * @return void
     */
    protected function getTplPath($myself, $tpl = ""){
        // получение названия класса объекта
        $name = lcfirst($this->getClassName($myself));
        // путь к шаблону по-умолчанию (для подключения файлов)

        $this->path = ROOT . "/vendor/freedom/widgets/{$name}/tpl/default/";

        // по-умолчанию подключаем шаблон виджета из ядра
        $this->tpl = __DIR__ . "/{$name}/tpl/default/default.php";
        if($tpl){
            // поиск не дефолтного шаблона в публичной директории
            if(is_file(WWW . "/tpl/widgets/{$name}/{$tpl}/{$tpl}.php")){
                $this->path = WWW . "/tpl/widgets/{$name}/{$tpl}";
                $this->tpl = WWW . "/tpl/widgets/{$name}/{$tpl}/{$tpl}.php";
            }
            // поиск в директории ядра приложения
            elseif(is_file(__DIR__ . "/tpl/{$tpl}/{$tpl}.php")){
                $this->path = ROOT . "/vendor/freedom/widgets/{$name}/tpl/{$tpl}";
                $this->tpl = __DIR__ . "/tpl/{$tpl}/{$tpl}.php";
            }
        }
    }

}