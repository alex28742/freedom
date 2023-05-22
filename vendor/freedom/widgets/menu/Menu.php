<?php
namespace fm\widgets\Menu;
use fm\core\Db;
use fm\core\TSingleton;
use fm\libs\Cache;
use PHPMailer\PHPMailer\Exception;

/**
 * Description of Menu
 *
 * @author als
 */
class Menu {
    protected $data; // данные получаемые из БД (массив категорий)
    // параметры принимаемые на вход
    protected $params = [
        'table' => '', // таблица
        'tpl' => 'default', // шаблон
        'container' => 'ul', // обертка (ul, select..)
        'class' => 'menu', // класс для обертки
        'cache' => 3600, // по умолчанию на 1 час
        'cacheKey' => '', // уникальный идентификатор, напр. (main-menu)
        'debug' => false
        ];
    protected $tree; // многомерный массив построенного дерева категорий
    protected $menuHtml; // сформированный для вывода html
    protected $db; // ссылка на объект подключения к БД
    
    /**
     * Принимает массив параметров
     * @param array $params
     * string table 
     * string tpl
     * string container
     * string cache
     * bool debug
     */
    public function __construct(array $params) {
        $this->db = Db::getInstance();
        // получаем все настройки
        if(is_array($params)){
            foreach ($params as $key => $val){
                if(isset($this->params[$key]) && $val !== ''){
                    $this->params[$key] = $val;
                }
            }
        }
        if($this->params['table'] === '' || !is_string($this->params['table'])){
            throw new \Exception("В виджет меню не передан параметр table - таблица БД");
        }
        
        if($this->params['cache'] && $this->params['cacheKey'] == ''){
            throw new \Exception("Не задан уникальный идентификатор меню при вызове (cacheKey)");
        }
        // включение сообщений об ошибках в БД
        if($this->params['debug']){
            $this->db->fancyDegug(true);   
        }
        $this->run();
        $this->output();
    }
    
    /**
     * Запускаем все методы и выводим меню в шаблон (echo)
     */
    public function run(){
        // если включено кеширование
        if($this->params['cache'] && is_int($this->params['cache'])){
            $cache = new Cache();
            // пытаемся получить меню из кеша
            $this->menuHtml = $cache->get($this->params['cacheKey']);
            if(!$this->menuHtml){ // если не получили, выполняем запрос к БД
                $this->initData();
                // помещаем в кэш
                $cache->set($this->params['cacheKey'], $this->menuHtml, $this->params['cache']);
            }
        }else{
            $this->initData();
        }    
    }
    
    public function initData(){
        // получение ассоц. массива категорий
        $this->data = $this->db->getAssos("SELECT * FROM {$this->params['table']}");
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
    }
    
    /**
     * Получение многомерного массива "дерева" категорий с потомками
     * @param array $data Должен сожержать id текущего пункта и parent родителя
     * @return array
     */
    protected function getTree(){
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node){
            // если родитель = 0, т.е. пуст
            if(!$node['parent']){
                $tree[$id] = &$node;
            }else{ // строим дерево
                $data[$node['parent']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }
    
    /**
     * Проход по дереву array и формирование html кода (собираю строку)
     * @param type $tree
     * @param type $tab
     * @return string $str Готовый html код
     */
    protected function getMenuHtml($tree, $tab = ''){
        if(!is_array($tree)){
            throw new Exception('$tree must be array!');
        }
        // рекурсивно заполняем строку
        $str = '';
        foreach($tree as $id => $category){
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str; // готовый html код
    }
    
    /**
     * Используя сформированный массив, на основе шаблона формирует вывод
     * @param type $category
     * @param type $tab
     * @param type $id
     */
    protected function catToTemplate($category, $tab, $id){
        // не выводим html а возвращаем, поэтому включаем буферизацию
        ob_start();
        // ищем шаблон в публичной директории проекта
        if(is_file(WWW . "/tpl/menu/{$this->params['tpl']}/{$this->params['tpl']}.php")){
            require WWW . "/tpl/menu/{$this->params['tpl']}/{$this->params['tpl']}.php";
        }else{ // если не найден, подключаем из ядра
             require __DIR__ . "/tpl/{$this->params['tpl']}/{$this->params['tpl']}.php";
        }
       
        return ob_get_clean(); // возвращаем содержимое буфера и очищаем
    }
    
    protected function output(){
        echo "<{$this->params['container']} class='{$this->params['class']}'>";
        echo $this->menuHtml;
        echo "</{$this->params['container']}>";
    }
}
