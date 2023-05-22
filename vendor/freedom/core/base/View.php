<?php

namespace fm\core\base;

use fm\core\App;

class View
{
    /** текущий маршрут
     * @var array
     */
    public array $route = [];
    /**
     *  текущий вид
     * @var string
     */
    public string $view = '';
    /**
     * текущий шаблон
     */
    public $layout;

    // путь к ресурсам шаблона
    public $template = "/public/tpl/templates/default";
    
    public static $meta = ['title' => '', 'description' => '', 'keywords' => ''];
    
    public $scripts = []; // скрипты в видах.

    public function __construct($route, $layout, $view)
    {

        $this->route = $route;
        // если layout установлен в false, значит указано не подключать шаблон
        if($layout === false){
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT;
            // поулчаю путь к ресурсам шаблона
            $this->template = "/public/tpl/templates/{$this->layout}";
        }
        $this->view = $view;
    }

    /** Подключение Шаблона и Вида
     * @param $vars  mixed Пользовательские данные передаваемые в вид из экшена
     * @return void
     */
    public function render($vars){
        // извлекаем элементы массива $vars, создавая одноименные переменные пользовательских данных
        if(is_array($vars)){
          extract($vars);  
        } 
        $this->route['prefix'] = str_replace('\\', '/', $this->route['prefix']);
        // подключаем вид если вид не отключен в экшене контроллера
        if($this->view){
            $file_view = APP . "/views/{$this->route['prefix']}{$this->route['controller']}/{$this->view}.php";

            if(COMPRESS){ // сжатие за счет удаления пустот в Виде
                ob_start([$this, 'compressPage']); // коллбэк функция сжатия
            }
            elseif (COMPRESS_GZ){ // сжатие на сервере за счет архивации данных
                header("Content-Encoding: gzip");
                ob_start('ob_gzhandler'); // включение сжатия на сервере
            }
            else{
                ob_start();
            }

            //////
            if(is_file($file_view)){
                require $file_view;
            }else{
                throw new \Exception("<p>Не найден вид {$file_view}</p>");
            }

            // получили вид, перед получением шаблона
            //$content = ob_get_clean();
            $content = ob_get_contents(); // возвращаем буфер из колбэк функции compressPage()
            ob_clean();
        }


        // если не было указано Не подключать шаблон

        if(false !== $this->layout){
            // подключаем шаблон
            //$file_layout = APP . "/layouts/{$this->route['prefix']}{$this->layout}.php";
            $file_layout = APP . "/layouts/{$this->route['prefix']}{$this->layout}/{$this->layout}.php";
            if(is_file($file_layout)){
                // очищаем вид от скриптов
                $content = $this->getScripts($content);
                // сохраняем скрипты в массив который будет доступен в шаблоне
                //$scripts = $this->scripts[0] ?: [];
                
                require $file_layout; // внутри выводим $content
            }else{
                throw new \Exception("<p>Не найден шаблон {$this->layout}</p>");
            }
        }

    }

    /**
     * Получаем скрипты из вида (в $this->scripts), очищаем $content
     * Из переменной $content содержащей вид, вырезаем скрипты, если они там
     * есть, сохраняем их в $this->scripts, возвращаем "чистый" $content
     * @param type $content
     * @return type
     */
    public function getScripts($content){
        // шаблон регулярного выражения
        $pattern = "#<script.*?>.*?</script>#si";
        // проверяем есть ли скрипты в видах, вырезаем если есть
        preg_match_all($pattern, $content, $this->scripts);
        // если что-то было найдено $this->scripts не пуст
        if(!empty($this->scripts)){
            // в контенте вырезаем скрипты которые были найдены (заменяем '')
            $content = preg_replace($pattern, '', $content);
            // добавляем массив скриптов в свойство объекта приложения для вывода в эпилоге
            $app = App::getInstance(); // глобальный объект приложения
            foreach ($this->scripts[0] as $script){
                array_push($app::$registry->scripts, $script);
            }
        }
        return $content;
        
    }
    
    /**
     * Метод добавляющий найденные скрипты в класс регистратора, для вывода в эпилоге
     */
    public function addScripts(){
        $app = App::getInstance();
        if(!empty($this->scripts[0] && is_array($this->scripts[0]))){
            $app::$registry->scripts = $this->scripts[0];
            foreach ($this->scripts[0] as $script){
                echo $script;
            }
        }
    }
    
    /**
     * Распечатка метаданных в шаблоне
     */
    public static function getMeta(){
        echo '<title>' .self::$meta['title'].'</title>
        <meta name="description" content="'.self::$meta['description'].'">
        <meta name="keywords" content="'.self::$meta['keywords'].'">';    
    }
    
    /**
     * Установка мета данных
     * @param type $title
     * @param type $description
     * @param type $keywords
     */
    public static function setMeta($title = '', $description = '', $keywords = ''){
        self::$meta['title'] = $title;
        self::$meta['description'] = $description;
        self::$meta['keywords'] = $keywords;
    }


    /** Колбэк функция (метод) для сжатия Вида
     * @param $buffer
     * @return string
     */
    protected function compressPage($buffer){
        if(!COMPRESS) return $buffer; // возврат без обработки
        $search = [ // что ищем (шаблоны регулярных выражений)
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        ];
        $replace = [ // на что заменяем каждое выражение описанное в search
            '>',
            '<',
            '\\1',
            ''
        ];
        return preg_replace($search, $replace, $buffer);
    }

    /** Метод подключения включаемого файла в layout.
     * @param $file
     * @return void
     */
    public function IncludeFile($file){
        $file = APP . "/layouts/{$this->layout}/inc/{$file}.php";
        if(is_file($file)){
            require $file;
        }else{
            echo "File {$file} not found...";
        }
    }

    /** Метод подключающий стили найденные в виджетах
     * @return void
     */
    public function getCSS(){
        // получаю список файлов с помощью класса Collector
        $css = [
            "/assets/css/widgets0.css",
            "/assets/css/widgets1.css",
            "/assets/css/widgets2.css",
        ];
        // получаю все данные....

        // создаю общий файл и получаю путь к нему

        // подключаю общий файл...
        foreach ($css as $item){
            echo "<link href='{$item}' rel='stylesheet' type='text/css'>";
        }
    }
    
    
    
}