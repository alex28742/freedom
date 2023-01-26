<?php

namespace app\controllers;

use fm\core\base\View;

class UserController extends AppController
{
    public function signupAction(){
        View::setMeta('Регистрация');

        debug($_GET, false, true);
        if (!empty($_POST)){
            debug($_POST, true);
        }
    }

    public function loginAction(){

    }

    public function logoutAction(){

    }
}