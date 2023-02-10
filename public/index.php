<?php

session_start();

use fm\core\Router;
use fm\core\Registry;

// Константы
define("DEBUG", 1); // 1 - режим разработки, 0 - режим продакшен (запись в лог).
define("COMPRESS", 0); // true / false - сжатие Вида
define("COMPRESS_GZ", 0); // сжатие с помощью gz архивации на сервере

const WWW = __DIR__; // путь к текущей папке public
define('CORE', dirname(__DIR__). '/vendor/freedom/core'); // путь к папке ядра
define('ROOT', dirname(__DIR__)); // путь к корню
define('APP', dirname(__DIR__). '/app'); // путь к папке app
define('LIBS', dirname(__DIR__). '/vendor/freedom/libs'); // путь к папке ядра libs
const LAYOUT = 'default'; // шаблон по умолчанию
define('CACHE', dirname(__DIR__) . '/tmp/cache'); // место хранения файлов кеша
define("LOGFILE", ROOT . '/tmp/error.log'); // путь к файлу логов


require __DIR__ .'/../vendor/autoload.php';


$query = rtrim($_SERVER['QUERY_STRING'], '/');
//require '../vendor/freedom/core/Router.php';
//require '../vendor/freedom/libs/Helper.php';
require '../vendor/freedom/libs/functions.php';

// temp
//require '../app/controllers/Main.php';
// автозагрузка
/*spl_autoload_register(function($class){
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    //$file = APP . "/controllers/$class.php";
    if(is_file($file)){
        require_once $file;
    }
});
 * */
 
//$tmp = new fm\libs\Cache();
//dump($tmp, true);

// создаем основной объект приложения, который будет доступен глобально
new \fm\core\App; 

// здесь могу переопределить правила (до дефолтных)
//Router::add('^page/(?P<action>[a-z-]+/(?P<alias>[a-z-]+$', ['controller' => 'Page']);
//Router::add('^page/(?P<alias>[a-z-]+$', ['controller' => 'Page', 'action' => 'view']);

// дефолтные правила - обработка пустой строки

// обработка правила для админки prefix - название папки в контроллерах
Router::add('^admin$', ['controller' => 'User', 'action' => 'index', 'prefix' => 'admin']); 
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']); 

Router::add('^$', ['controller' => 'Main', 'action' => 'index']); // обработка пустой строки
// разрешаем латиницу и тире для контроллера '[a-z-]+/' и экшена [a-z-]+
// чтобы запоминать сегменты, группируем в ()
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');// первый сегмент - контроллер, второй - экшен


Router::dispatch($query);




