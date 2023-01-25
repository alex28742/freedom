<?php

$config = [
    // компоненты которые должны инициилизироваться при загрузке
    'components' => [ 
        'cache' => 'classes\Cache',
        'mail' => 'classes\Mail',
    ],
    'settings' => [], // массив настроек
];

// автозагрузка
spl_autoload_register(function($class){
    $file = str_replace('\\', '/', $class) . '.php';
    //$file = APP . "/controllers/$class.php";
    if(is_file($file)){
        require_once $file;
    }
});

/**
 * Description of index
 *
 * @author als
 */
class Registry {
    public static $objects = [];
    protected static $instance;
    
    protected function __construct() {
        global $config;
        foreach ($config['components'] as $name => $component){
            self::$objects[$name] = new $component;
        }
    }
    
    public static function getInstance() {
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    public function getList(){
        echo '<pre>';
        var_dump(self::$objects);
        echo '</pre>';
    }
    
    /**
     * Магический метод (вызывается автоматически если идет
     * обращение к неизвестному свойству
     * @param type $name
     */
    public function __get($name) {
        if(is_object(self::$objects[$name])){
            // возвращаем объект, если найден
            return self::$objects[$name];
        }
    }
    
    /**
     * Данный маг. метод позволит добавлять объекты в контейнер
     * @param type $name
     * @param type $value
     */
    public function __set($name, $object) {
        // если не существует объект с таким именем
         if(!isset(self::$objects[$name])){
             self::$objects[$name] = new $object;
         }
    }
    
    
    
    
}

$app = Registry::getInstance();
//$app->getList();
$app->mail->go();
$app->test2 = "\classes\Test2"; //   добавляю объект
$app->getList();
$app->test2->Hello();  // вызываю метод добавленного объекта.
