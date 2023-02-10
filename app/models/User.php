<?php

namespace app\models;

use fm\core\base\Model;
use fm\core\Form;

class User extends Model
{
    public object $form; // объект для работы с формами
    protected string $table = 'user'; // таблица
    protected string $type = ''; // тип формы (signup, signin...)
    protected array $err_unique = []; // ошибки при проверке уникальности в БД

    protected array $data = []; // контейнер данных полученных из формы

    // сообщение об успешной валидации
    protected array $success = [
        'signup' => "Регистрация успешна!",
        'signin' => "Вы авторизовались!",
    ];

    protected array $errors = [
        'signup' => "Ошибка регистрации. Попробуйте позже",
        'signin' => "Логин / пароль введены неверно",
    ];

    // аттрибуты форм (что ожидаю получить из форм)
    protected array $attributes = [
        'signup' => [
            'name', 'login', 'password', 'email',
        ],
        'signin' => [
            'login', 'password',
        ],
    ];

    // правила применяемые для валидации форм
    protected array $rules = [
        'signup' => [ // аттрибуты для формы регистрации
            'required' => [ // обязательные для заполенния
                ['password'],
                ['email'],
            ],
            'email' => [ // поля проверяемые как e-mail
                ['email']
            ],
            'lengthMin' => [ // проверка на минимальную длину
                ['password', 6],
                //['name', 3],
            ],
            'alphaNum' => [ // состоит только из цифр 0-9 и букв a-z
                ["login"],
            ],
//            'ascii' => [ // состоит только из букв (латинских)
//                ["name"],
//            ],
        ],
        'signin' => [ // аттрибуты для формы авторизации
            'requiredWith' => [ // обязательные для заполенния
                ['password'],
                ['email'],
            ],
            'email' => [ // поля проверяемые как e-mail
                ['email'],
            ],
            'lengthMin' => [ // проверка на минимальную длину
                ['password', 6]
            ],
        ],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /** Получение данных из формы для дальшейшей работы (валидации, сохранения..)
     * Метод инициализирует свойства, создает объект формы
     * @param array $data Данные из массива POST / GET
     * @param string $type Тип формы (signin, signup...)
     * @return void
     */
    public function loadForm(array $data = [], string $type = 'signin'){
        $this->type = $type;
        $this->data = $this->cleanData($data);
        $attributes = $this->attributes[$this->type]; // получаю артибуты нужной формы
        // Получаю объект для валидации полей формы
        $this->form = new Form();
    }

    /** Очистка данных пришедших из формы от вредоносного кода и мусора
     * @param $data
     * @return array
     */
    protected function cleanData($data): array{
        $arr = [];
        foreach ($data as $name => $val){
            $arr[$name] = trim(strip_tags($val));
        }
        return $arr;
    }


    public function validateForm():bool{
        // подгружаю данные в валидатор
        $this->form->load($this->attributes[$this->type], $this->data);
        // добавляю правила валидации
        $this->form->rules($this->rules[$this->type]);
        // запускаю валидацию (ошибки если есть записываются в $_SESSION['errors]
        return $this->form->validate();
    }

    /** Получение данных из формы для вывода в поля формы (пароль вырезан)
     * @return array
     */
    public function getFormData():array{
        // удаляю введенный пароль
        $data = $this->data;
        unset($data['password']);
        return $data;
    }



    /** Получение списка ошибок строкой в виде списка ul > li
     * @return string
     */
    public function errorsUl():string{
        $errors = array_merge($this->form->errors, $this->err_unique);
        //dump($this->form->errors);
        if(empty($errors)) return "";
        $string = '<ul>';
        // создаю строку
        foreach ($errors as $error){
            foreach ($error as $item){
                $string .= "<li>$item</li>";
            }
        }
        $string .= '</ul>';
        return $string;
    }


    /** Сохранение пользователя в БД
     * @return bool
     */
    public function save(): bool{
        // пытаюсь сохранить пользователя
        $user = $this->db->dispense($this->table);
        //$groups = 'groups';
        $data = $this->getFormData(); // данные без пароля
        // сохраняю все данные кроме пароля
        foreach($data as $attr => $val){
            $user->$attr = $val;
        }
        // хэширую и сохраняю пароль
        $user->password = password_hash($this->data["password"], PASSWORD_DEFAULT);
        // массив групп, по-умолчанию 2 - читатель
        $user->groups = serialize([2]);
        // если сохранение успешно
        if($this->db->store($user)){
            $_SESSION['success'] = $this->success[$this->type];
        }
        return $this->db->store($user);
    }

    /**
     * @param array $arr Массив вида ['login', 'email'] полей кот. должны быть уникальны
     * @return bool
     */
    public function checkUnique(array $arr = []):bool{
        // собираю массив - добавляю данные аттрибутам
        $attr = $this->getArrayForCheck($arr);
        // проверяю записи в БД на уникальность
        foreach ($attr as $name => $val){
            if($this->db->findOne($this->table, "{$name} = ? LIMIT 1", [$val])){
                $this->err_unique['unique'][] = "Значение $val для поля $name уже занято другим пользователем";
            }
        }
        if(!empty($this->err_unique)){
            return false; // искомое найдено в БД, значение не уникально
        }
        return true;
    }

    protected function getArrayForCheck($attr = []):array{
        $arr = [];
        // дополняю входящий массив наименований полей значениями
        foreach ($attr as $name){
            $arr[$name] = $this->data[$name];
        }
        //dump($arr, true);
        return $arr;
    }

    /** Получить ошибки валидатора
     * @return array
     */
    public function getErrorsValidator():array{
        return $this->form->errors;
    }

    /** Получить ошибки проверки на уникальность значений полей
     * @return array
     */
    public function getErrorsUnique():array{
        return $this->err_unique;
    }

    /** Метод записывает строку ошибок в виде списка ul в массив $_SESSION['errors']
     * @return void
     */
    public function showErrors(){
        $_SESSION['errors'] = $this->errorsUl();
    }

    /** Метод авторизации. Получает пользователя из БД и записывает в сессию $_SESSION['user'][$key]
     * @return bool
     */
    public function login(): bool{
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
        if($login && $password){
            // получение пользователя nо логину
            $user = $this->db->findOne('user', 'login = ? LIMIT 1', [$login]);
            if($user){ // если найден
                if(password_verify($password, $user->password)){
                    foreach ($user as $key => $val){
                        if($key !== 'password') $_SESSION['user'][$key] = $val;
                    }
                    $_SESSION['success'] = $this->success['signin'];
                    return true;
                }
            }
        }
        $_SESSION['errors'] = $this->errors['signin'];
        return false;
    }


}
