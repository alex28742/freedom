<!-- epilog -->
<?php
$app = \fm\core\App::getInstance();
// вывод скриптов собранных в виде прямо в тело страницы в шаблон перед закрывающим </body>
if(!empty($app::$registry->scripts)){
    foreach ($app::$registry->scripts as $script){
        echo $script;
    }
}

// Добавление ссылки объединенного файла со скриптами собранными из зарегистрированных в системе виджетов (которые отработали)
$app->includeJS();
?>

</body>
</html>
