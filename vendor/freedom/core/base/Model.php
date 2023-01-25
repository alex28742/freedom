<?php


namespace fm\core\base;
use fm\core\Db;

/**
 * Description of Model
 *
 * @author als
 */
abstract class Model {
    public $db; // указатель на активное подключение


    /**
     * 
     * @param type $table Имя таблицы с которой работает модель
     */
    public function __construct() {
        $this->db = Db::getInstance(); // получаем активное подключение
    }
    
    /**
     * Обертка над Db::execute (запрос без получения данных из БД)
     * @param type $sql
     */
//    public function query($sql){
//        return $this->pdo->execute($sql);
//    }
    
    /**
     * Получение всех данных из таблицы с которой работает модель
     * @param type $param
     */
//    public function findAll() {
//        $sql = "SELECT * FROM {$this->table}";
//        return $this->pdo->query($sql);
//    }
    
    /**
     * Выборка одной записи из БД
     * @param type $id
     * @param type $field по какому полю мы хотим выбирать данные
     */
//    public function findOne($id, $field = '') {
//        $field = $field ?: $this->pKey;
//        // для защиты от инъекции используем подготовленные выражения
//        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1"; 
//        return $this->pdo->query($sql, [$id]);
//    }
    
    /**
     * Выборка по произвольному sql запросу
     * @param type $sql
     * @param type $params
     * @return type
     */
//    public function findBySql($sql, $params = []){
//        return $this->pdo->query($sql, $params);
//    }
    
    /**
     * 
     * @param type $str Часть строки которую ищем
     * @param type $field Поле в котором ищем
     * @param type $table Таблица в которой ищем
     * @return type array
     */
//    public function findLike($str, $field, $table = ''){
//        $table = $table ?: $this->table;
//        $sql = "SELECT * FROM $table WHERE $field LIKE ?";
//        return $this->pdo->query($sql, ['%'.$str.'%']);
//    }
    
}
