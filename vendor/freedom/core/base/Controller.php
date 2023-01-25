<?php

namespace fm\core\base;
use fm\core\base\View;

abstract class Controller
{
    public array $route = [];
    public string $view = '';
    public $layout;
    public array $vars = []; // массив для хранения данных передаваемых в вид из экшена
    public function __construct($route){
        $this->route = $route;
        $this->view = $route['action'];
        $this->layout = LAYOUT;
    }

    public function getView(){
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars); // передаем пользовательские данные
    }

    /** Метод передачи данных из экшена в вид
     * @param $vars
     * @return void
     */
    public function set($vars){
        $this->vars = $vars;
    }
    
    /**
     * Метод проверяющий пришел ли запрос по ajax (асинхронно) или по http
     * @return bool
     */
    public function isAjax(): bool{
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower
            ($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            return true;
        }
        return false;
    }
    
    /**
     * Подключение вида, когда к примеру шаблон отключен
     * @param type $view - строка типа 'index' (название вида)
     * @param type $vars
     */
    public function loadView($view, $vars = []) {
        extract($vars); // извлекаем переменные
        // подключаем вид в котором будут доступны переменные
        require APP ."/views/{$this->route['controller']}/{$view}.php";
        $this->layout = false; // поскольку вручную подключаем, отк. шаблон
    }

}