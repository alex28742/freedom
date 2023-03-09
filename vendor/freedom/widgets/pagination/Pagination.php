<?php

namespace fm\widgets\pagination;

class Pagination
{
    public $currentPage; // номер текущей страницы
    public $perPage; // по сколько записей выводить на странице
    public $totalRecords; // общее количество записей
    public $totalPages; // общее количество страниц
    public $uri; // базовый адрес к которому будем добавлять пагинацию
    public $tpl; // используемый шаблон

    /**
     * @param int $page номер текущей страницы, получаемый из массива GET
     * @param int $perPage установка количества вывода на одной странице
     * @param int $totalRecords  общее количество записей в БД
     * @param string $tpl шаблон (опционально)
     */
    public function __construct($page, $perPage, $totalRecords, $tpl = "default")
    {
        $this->tpl = $tpl;
        $this->perPage = $perPage;
        $this->totalRecords = $totalRecords;
        $this->totalPages = $this->getTotalPages();
        $this->currentPage = $this->getCurentPage($page);
        $this->uri = $this->getParams();
    }

    /** общее количество записей делим на количество записей на одной странице
     * @return int
     */
    public function getTotalPages(){
        return ceil($this->totalRecords / $this->perPage) ?: 1; // округление в большую сторону
    }

    /** Получение номера текущей страницы. Делаем обработку, т.к. данные можно подменить в url (get)
     * @param int $page
     * @return int
     */
    public function getCurentPage($page){
        if(!$page || $page < 1) $page = 1;
        if($page > $this->totalPages) $page = $this->totalPages;
        return $page;
    }

    /** Возвращает число - с какой записи начинать выборку
     * @return int
     */
    public function getStart(){
        // (1 - 1) * 2 = 0 выборка начинается с нулевой записи
        // (2 - 1) * 2 = 2 выборка начинается со второй записи (номер записи в БД - 3)
        return ($this->currentPage - 1) * $this->perPage;
    }

    /** Формирование строки get параметров (вырезаем page=N из строки параметров)
     * @return string
     */
    protected function getParams(){
        $url = $_SERVER['REQUEST_URI'];
        // поулчаю отдельно get параметры
        $url = explode('?', $url); // $url[1] = "lang=ru&page=4"
        $uri = $url[0] . '?'; // добавляю ? к url строке
        // если есть параметры в get
        if(isset($url[1]) && $url[1] != ''){
            // получаю массив get параметров
            $params = explode('&', $url[1]);
            foreach ($params as $param){
                // если НЕ page= то к get параметрам добавляем $param&
                if(!preg_match("#page=#", $param)){
                    $uri .= "{$param}&amp;";
                }
            }
        }
        return $uri;
    }

    /** Магический метод. Приводит объект к строке
     * echo new Pagination() интерпретатор будет искать метод __toString() и вызовет
     * @return string
     */
    protected function __toString(){
        // определение используемого шаблона
        ob_start();
        // 1. Поиск шаблона в публичной директории public/tpl/pagination/...
        if(is_file(WWW . "/tpl/pagination/{$this->tpl}/{$this->tpl}.php")){
            require WWW . "/tpl/pagination/{$this->tpl}/{$this->tpl}.php";
        }else{ // подключение шаблона ядра
            require __DIR__ . "/tpl/{$this->tpl}/{$this->tpl}.php";
        }
        return ob_get_clean();
    }

}