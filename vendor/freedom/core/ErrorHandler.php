<?php

namespace fm\core;



/**
 * Description of ErrorHandler
 *
 * @author als
 */
class ErrorHandler {
    //put your code here
     public function __construct() {
        if(DEBUG){
            error_reporting(-1); //  уровень ошибок E_ALL
        }else{
            error_reporting(0);
        }
        // указываем свой обработчик не фатальных ошибок
        set_error_handler([$this, 'errorHandler']);
        // регистрируем свой метод обработки фатальных ошибок
        // чтобы погасить стандартный вывод, включаем буферизацию
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        
        // регистрируем собственный обработчик для исключений Exception
        set_exception_handler([$this, 'exceptionHandler']);
    }
    
    
    // свой обработчик ошибок (если вернет false, ошибка всплывет выше)
    public function errorHandler($errno, $errstr, $errfile, $errline){
        // в режиме дебага выводим ошибки на экран в любом случае,
        // либо если ошибки критические
        if(DEBUG || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])){
            // получаем информацию об ошибке и передаем методу
            $this->displayError($errno, $errstr, $errfile, $errline);
        }
        // логируем ошибку
        $this->writeLog($errno, $errstr, $errfile, $errline);
        
        
        return true;
    }
    
    /**
     * Свой метод логирования (записи в файл) ошибки
     * @param type $no Код ошибки
     * @param type $msg Сообщение об ошибке
     * @param type $file Файл в котором произошла ошибка
     * @param type $line Строка на которой произошла ошибка
     */
    public function writeLog($no = '', $msg = '', $file = '', $line = ''){
        error_log("[". date('Y-m-d:H:i:s')."] Текст ошибки: {$msg} | Файл: {$file} | Строка: {$line}\n===\n", 3, LOGFILE);
    }
    
    
    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500){
        http_response_code($response); // отправляем код ошибки
        //
        if($response == 404 && !DEBUG){
            require WWW . '/errors/404.html';
            die;
        }
        // подключаем страницу ошибки в зависимости от статуса DEBUG
        if(DEBUG){
            require WWW .'/errors/dev.php';
        }else{
            require WWW . '/errors/prod.php';
        }
        die;
    }
    
    // Свой обработчик фатальных ошибок
    public function fatalErrorHandler(){
        $error = error_get_last();
        if(!empty($error) && 
                $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)){
            // Запись в лог
            $this->writeLog($error['type'], $error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError(
                    $error['type'],
                    $error['message'],
                    $error['file'],
                    $error['line']
                );
        }else{
            ob_end_flush();
        }
    }
    
    // Свой обработчик исключений
    public function exceptionHandler($e){
        // Запись в лог
        $this->writeLog('Исключение', $e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

}
