<?php
$TEMPLATE = "/public/tpl/templates/{$this->layout}";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <? \fm\core\base\View::getMeta(); ?>
    <link href="/public/libs/bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    стили шаблона-->

    <link rel="stylesheet" href="<?=$TEMPLATE?>/css/style.css">

</head>
<style>

</style>
<body>
<code>Default Template</code>
<?// if(isset($_SESSION['user'])) {  dump($_SESSION['user']); } ?>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Ссылка</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Личный кабинет
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/user/login">Войти</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/user/signup">Регистрация</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/user/logout">Выйти</a></li>
                    </ul>
                </li>
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link disabled">Отключенная</a>-->
<!--                </li>-->
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск">
                <button class="btn btn-outline-success" type="submit">Поиск</button>
            </form>
        </div>
    </div>
</nav>

<?=$content;?>


<br>
<div class="container">

</div>
<?//=debug(\vendor\freedom\core\Db::$countSql);?>
<?//=debug(\vendor\freedom\core\Db::$queries);?>
<script src="/public/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/public/libs/jquery/jquery.js"></script>
    
    
<?
// скрипты найденные в виде 
$this->addScripts();
?>
</body>
</html>
