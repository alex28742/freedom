<?php

/**
 * Базовый класс для Админки
 *
 * @author als
 */
namespace app\controllers\admin;
use fm\core\base\Controller;

class AppController extends Controller {
    
    //public $layout = 'admin'; // базовый шаблон админки
    
    public function __construct($route) {
        parent::__construct($route);
        $this->layout = 'admin';
    }
}
