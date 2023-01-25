<?php
namespace fm\core;
use app\controllers;
class Router
{
    protected static array $routes = []; // весь массив маршрутов (таблица маршрутов)
    protected static array $route = []; // текущий маршрут


    /**
     * Заполняем массив маршрутов
     * @param $regexp // регулярное выражение
     * @param $route // маршрут кот. соответствует url (опционально)
     * @return void
     */
    public static function add(string $regexp, array $route = []): void{
        self::$routes[$regexp] = $route;
    }

    /**
     * Метод для "распечатки" всего массива
     * @return array
     */
    public static function getRoutes(): array{
        return self::$routes;
    }

    /**
     * Метод получения маршрута (значение статического свойства)
     * @return array
     */
    public static function getRoute(): array{
        return self::$route;
    }

    /**
     * Определение какому выражению соответствует строка в url и запись
     *  маршрута то есть ищем совпадение с шаблоном
     * @param $url
     * @return bool
     */
    private static function matchRoute($url): bool{
        foreach (self::$routes as $pattern => $route) {
            if(preg_match("#$pattern#i", $url, $matches)){
                // из matches выбираю только строковые ключи (controller action)
                foreach($matches as $k => $v){
                    if(is_string($k))
                        $route[$k] = $v;
                }
                // если action пустой, присваиваем index
                if(!isset($route['action'])){
                  $route['action'] = 'index';  
                }
                // получаем prefix для админских контроллеров
                if(!isset($route['prefix'])){
                    $route['prefix'] = '';
                }else{
                    $route['prefix'] .= '\\';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }

        } return false;
    }

    /**
     * Создаем объект контроллера и вызываем его метод (экшена)
     */
    public static function dispatch($url):void{
        $url = self::removeQueryString($url); // обрезаем явные гет-параметры
        if(self::matchRoute($url)){
            // если совпадение найдено, создаю объект, вызываю метод
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';
            // проверяем есть ли у нас такой класс, подключаем
            if(class_exists($controller)){
                $cObj = new $controller(self::$route); // передаю параметр в конструктор
                // вызываем метод
                $action = self::lowerCamelCase(self::$route['action']).'Action';
                if(method_exists($cObj, $action)){
                    $cObj->$action(); // вызываем метод контроллера
                    $cObj->getView();
                }else{
                    //echo "Метод $controller::$action не найден";
                    throw new \Exception("Метод $controller::$action не найден", 503);
                }
            }else{
                //echo "Контроллер $controller не найден";
                throw new \Exception("Контроллер $controller не найден", 503);
            }
        }else{
            throw new \Exception("Страница не найдена", 404);
        }
    }

    /*
     * Привожу к верхнему регистру название контроллера TestController
     */
    private static function upperCamelCase($name):string{
        $name = str_replace('-', ' ', $name);
        $name = ucwords(($name));
        return str_replace(' ', '', $name);
    }

    /** Привожу название метода к виду testAction
     * @param $name
     * @return string
     */
    private static function lowerCamelCase($name):string{
        return lcfirst(self::upperCamelCase($name));
    }

    /** Отрезаем явные get параметры, оставляем только неявный.
     * @param $url
     * @return string
     */
    private static function removeQueryString($url):string{
        if($url){ // не пустая строка (Main -> index)
            $params = explode('&', $url, 2);
            if(!strpos($params[0], '=')){
                return rtrim($params[0], '/');
            }
        }
        return '';
    }
}