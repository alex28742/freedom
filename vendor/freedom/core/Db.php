<?php


namespace fm\core;
use R;

/**
 * Методы для работы с Базой Данных (singlton)
 *
 * @author als
 */
class Db {
    use TSingleton; // реализован метод getInstance()
    protected $pdo; // указатель на открытое подключение к серверу БД
    public static $countSql = 0; // общее количество запросов к БД
    public static $queries = []; // сохранение всех запросов.
    
    // приватный конструктор, для невозможности создать объект на лету
    private function __construct() {
        $db = require ROOT . '/config/config_db.php'; // получаем массив
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // сообщать об ошибках
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // получать только ассоц. массив
        ];
       require LIBS . '/rb.php';
       R::setup($db['dsn'], $db['user'], $db['pass'], $options);
       // R::freeze(true);
       //R::fancyDebug(true);
       //dump(R::testConnection());   
    }

    public function testConnection(){
        print_r(R::testConnection());
    }
    
    /**
     * Метод вывода сообщений об ошибках
     * @param type $flag
     */
    public function fancyDegug($flag = false){
        R::fancyDebug($flag);
    }
    
    // Базовые методы для работы с Базой Данных
    
    /**
     * Получение бина по имени таблицы (если таблицы нет - будет создана)
     * @param string $table Название таблицы
     * @return array
     */
    public function dispense($table){
        return R::dispense($table);
    }
    
    /** Сохранение объекта (запись в БД)
     * @param object $bean сохраняемый объект
     * @return int|string id записи которая изменялась
     * @throws \RedBeanPHP\RedException\SQL
     */
    public function store($bean){
        return R::store($bean);
    }

    /** Получение записи (бина) по id первичному ключу
     * @param string $table имя таблицы для выборки
     * @param int $id первичный ключ записи
     * @return \RedBeanPHP\OODBBean
     */
    public function load($table, $id){
        return R::load($table, $id);
    }
    
    /** Получение записей (массив бинов) по массиву идентификаторов (первичный ключ)
     * @param string $table имя таблицы
     * @param array $ids массив идентификаторов
     * @return array (массив бинов)
     */
    public function loadAll($table, $ids = []){
        return R::loadAll($table, $ids);
    }

    /** Поиск записи / записей по условию. Вернет массив бинов.
     * @param string $table имя таблицы
     * @param string $condition условие ("`age`> ? ORDER BY DESC"...)
     * @param array $params массив значений в том же порядке как опред. в условии
     * @return array (массив бинов)
     */
    public function find($table, $condition, $params){
        return R::find($table, $condition, $params);
    }

    /** Аналог метода find() но с LIMIT=1 Вернет один бин по условию или NULL
     * @param string $table
     * @param string $condition
     * @param array $param
     * @return \RedBeanPHP\OODBBean|NULL
     */
    public function findOne($table, $condition, $param){
        return R::findOne($table, $condition, $param);
    }

    /** Выбрать все, с заданной сортировкой (опционально) ORDER BY `name` ASC
     * @param string $table
     * @param string $order опционально
     * @return array
     */
    public function findAll($table, $order = null){
        return R::findAll($table, $order);
    }

    /** Выборка по указателям - по одной записи. while($user = $users->next())
     * @param string $table
     * @param string $order опционально
     * @return \RedBeanPHP\BeanCollection
     */
    public function findCollection($table, $order = null){
        return R::findCollection($table, $order);
    }

    /** Поиск по значениям полей. Вернет массив бинов или пустой массив
     * @param $table
     * @param array $desired массив полей для поиска. ['name' => 'petya vasechkin', ...]
     * @param string $order опционально напр. ORDER BY ’age' ASC
     * @return array если не найдет, вернет пустой массив, иначе - массив бинов
     */
    public function findLike($table, $desired = null, $order = null){
        return R::findLike($table, $desired, $order);
    }


    /** Вернет если будет найдено, или создаст и вернет.
     * @param string $table
     * @param array $fields Пример: ['name' => 'masyk', 'age' => 4]
     * @return \RedBeanPHP\OODBBean
     */
    public function findOrCreate($table, $fields = []){
        return R::findOrCreate($table, $fields);
    }

    /** Получить количество записей, либо все, либо по условию. Вернет int
     * @param $table
     * @param string $condition опционально. sql напр. 'WHERE `name`=?'
     * @param array $params опционально. массив значений, напр. ['robert']
     * @return int
     */
    public function count($table, $condition = "", $params = ""){
        return R::count($table,$condition, $params);
    }

    /** Удаление одиночного бина
     * @param $bean
     * @return void
     */
    public function trash($bean){
        R::trash($bean);
    }

    /** Удаление нескольких бинов (множественный бин)
     * @param $beans
     * @return void
     */
    public function trashAll($beans){
        R::trash($beans);
    }

    /** Удаление всех записей таблицы
     * @param string $table имя таблицы
     * @return void
     */
    public function wipe($table){
        R::wipe($table);
    }

    /** Конвертировать все бины в массив
     * @param $beans
     * @return array
     */
    public function exportAll($beans){
        return R::exportAll($beans);
    }

    /** Выполнение произвольного запроса
     * @param $sql
     * @param $bindings
     * @return array|int|null
     */
    public function exec($sql, $bindings = []){
        return R::exec($sql, $bindings);
    }
    
    /**
     * Выполнение произвольного запроса, с получением ассоц. массива
     * @param string query $sql Произвольный запрос
     * @return array Ассоциативный массив
     */
    public function getAssos($sql){
        return R::getAssoc($sql);
    }

    
    /**
     * Выполнение простого SQL запроса без получения данных из БД
     * @param type $sql Строка запроса
     * @param type $params Параметры в случае подготовленных запросов
     * @return type
     */
    /*public function execute($sql, $params = []) {
        self::$countSql++; // увеличиваем счетчик
        self::$queries[] = $sql; // сохраняю запрос для логов
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params); // ответ true / false (успех или неудача)
    }
     *
     */
    
    /**
     * Запросы подразумевающие выборку из БД (получение данных)
     * @param type $sql Строка запроса
     * @param type $params Параметры в случае подготовленных запросов
     * @return type
     */
    
    /*public function query($sql, $params = []){
        self::$countSql++; // увеличиваем счетчик
        self::$queries[] = $sql; // сохраняю запрос для логов
        $stmt = $this->pdo->prepare($sql);
         $res = $stmt->execute($params);
         if($res !== false){
             return $stmt->fetchAll();
         }
         return []; // если данные не получены, возвращаем пустой массив
    }*/
    
    
}
