<?php
/**
 * Description of UserController
 *
 * @author als
 */

namespace app\controllers\admin;
use app\controllers\admin\AppController;
use fm\core\base\View;

class UserController extends AppController {
    
    public function indexAction(){
        echo __METHOD__;
        dump($this->route);
        echo " layout = " .$this->layout;
        View::setMeta('Админка', 'Описание', 'Ключевики');
    }

    public function loginAction(){
//        if(!empty($_POST)){
//            View::setMeta("Авторизация");
//            $user->
//        }
    }
    
    public function testAction(){
        echo __METHOD__;
    }
}
