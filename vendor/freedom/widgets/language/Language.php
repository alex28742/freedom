<?php

namespace fm\widgets\language;

use fm\core\App;
use fm\core\Db;
use fm\core\Registry;
use fm\widgets\Widget;

/** Класс Singltone отвечающий за выбор языка приложения.
 * В контроллере AppController (в конструкторе) получаем список всех языков и язык по-умолчанию
 *
 */
class Language extends Widget
{
    protected $languages; // массив языков
    protected $language; // текущий язык
    protected $app; // глобальный объект приложения

    /**
     * @param string $tpl Название шаблона. (например my_tpl) Будет пытаться найти по пути public/tpl/widgets/language/... затем в ядре  vendor/freemom/widgets/language/...
     */
    public function __construct($tpl = "")
     {
        parent::__construct($this);
        // инициализация свойств путей к шаблону
        $this->getTplPath($this, $tpl);

        $this->app = App::getInstance();
        // получаем список языков в системе
        $this->languages = $this->app::$registry->getProperty('langs');
        // получаем базовый язык системы
        $this->language = $this->app::$registry->getProperty('lang');
        //
        $this->run();
    }


    protected function run(){
        echo $this->getHtml();
    }

    // Получение списка языков из БД
    public static function getLanguages($table){
        $db = Db::getInstance();
        // метод getAssoc вернет ассоц. массив где первое свойство указанное в строке sql будет ключем массива
        return $db->getAssos("SELECT code, title, base FROM $table ORDER BY base DESC ");
    }

    // Получение текущего (активного) языка
    public static function getLanguage($languages){
        // если в куках есть код языка и в списке языков мы его находим
        if(isset($_COOKIE['lang']) && array_key_exists($_COOKIE['lang'], $languages)){
            $key = $_COOKIE['lang'];
        }else{ // если в куках ничего нет, берем базовый язык из БД (тот что определен как base = 1)
            // получаем ключ из массива key() возвращает индекс элемента массива, на который в данный момент указывает внутренний указатель массива
            $key = key($languages);
        }
        $lang = $languages[$key]; // получаем массив только нужного языка по ключу (коду) en / ru...
        $lang['code'] = $key; // дополнительно добавляем код (ru/en..)
        return $lang;
    }

    // Получение Html
    protected function getHtml(){
        ob_start();
        // подключаем шаблон
        require_once $this->tpl;
        return ob_get_clean();
    }

}