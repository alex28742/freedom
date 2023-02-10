<?php

/* Класс использует стороннюю библиотеку https://github.com/vlucas/valitron

// создаю объект
 $form = new \fm\core\Form();
// перечисляю данные которые хочу получить из формы
$attr = ['login', 'name', 'email', 'password'];
// передаю данные и массив POST / GET
$form->load($attr, $_POST);
// определяю правила вадидации, какие поля и как валидировать
// указываю обязательные поля
$form->rule('required', ['login', 'password', 'email']);
// указываю какое поле проверять как email
$form->rule('email', ['email']);
// минимальная длина поля
$form->rule('lengthMin', 'password', 6);
// вызываю валидатор, получаю ответ (true / false)
$v = $form->validate();
// если есть ошибки (false), получаю массив ошибок
if($v === false){
   $errors = $form->errors();
}
// альтернативный синтаксис правил:
$ruls = [ // аттрибуты для формы регистрации
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
        ];
*/

namespace fm\core;

use Valitron\Validator;

class Form
{
    protected object $validator; // объект валидатора (используемая сторонняя библиотека)
    protected array $attributes = []; // ожидаемые данные из формы
    public array $errors = []; // массив ошибок
    protected object $db; // контейнер для объекта работы с БД

    public function __construct()
    {
        $this->db = Db::getInstance();
    }


    /** Получает данные на вход, создает объект валидатора
     * @param array $attr атрибуты (ожидаемые данные из формы - поля) ['name', 'email', 'group' => 2, ...]
     * @param array $data не подготовленные данные из формы (массив POST или GET)
     * @return void
     */
    public function load($attr = [], $data = []){
        foreach ($attr as $item){
            $this->attributes[$item] = '';
        }

        foreach ($this->attributes as $name => $val){
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
        Validator::langDir(WWW . '/langs/validator');
        Validator::lang('ru');
        $this->validator = new Validator($this->attributes);
    }

    /** Задаю правила валидации
     * @param array $rule
     * @return void
     */

    public function rules(array $rule){
        $this->validator->rules($rule);
    }

    /** Валидация данных
     * @return bool true / false
     */
    public function validate(){
        $res = $this->validator->validate();
        if(!$res){
            $this->errors = $this->validator->errors();
        }
        return $res;
    }

    /** Получение списка ошибок в виде массива
     * @return array
     */
    public function errors(){
        return $this->errors;
    }

    /** Получение итоговых данных
     * @return array
     */
    public function data(){
        return $this->attributes;
    }




}