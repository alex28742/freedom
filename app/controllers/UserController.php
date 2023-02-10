<?php

namespace app\controllers;

use app\models\User;
use fm\core\base\View;
use fm\core\Form;

class UserController extends AppController
{
    public function signupAction(){
        View::setMeta('Регистрация');
        $data = [];
        $user = new User(); // создаю Модель
        // получаю данные из формы
        if(!empty($_POST)){
            // Получаю данные, создаю объект валидатора
            $user->loadForm($_POST, 'signup');
            // валидирую данные и проверяем уникальность полей
            $validator = $user->validateForm();
            $unique = $user->checkUnique(["login", "email"]);
            if($validator && $unique){ // нет ошибок валидации
                $user->save();
            }else{
                $user->showErrors();
            }
            // получаю данные (очищенные). для подстановки в поля формы
            $data = $user->getFormData(); // date без пароля

        }
        //dump($_SESSION['errors']);
        $this->set(compact('data'));

    }

    public function loginAction(){
        if(!empty($_POST)){
            View::setMeta("Авторизация");
            $user = new User();
            $user->login();
        }
        $login = isset($_POST['login']) ? trim($_POST['login']) : '';
        $this->set(compact('login'));
    }

    public function logoutAction(){
        $this->layout = false;
        $this->view = false;
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            redirect('/user/login');
        }else{
            redirect();
        }
    }
}