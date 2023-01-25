<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <? fm\core\base\View::getMeta(); ?>
    <link href="/public/libs/bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    стили шаблона-->
    <link rel="stylesheet" href="/public/css/layouts/<?=$this->layout?>.css">
<!--    общие стили проекта -->
    <link rel="stylesheet" href="/public/css/main.css">
</head>
<body>
<h1>Admin Template</h1>

<?=$content;?>


<br>
<div class="container">
<div class="panel panel-default">
    <div class="panel-heading">Запросов к БД:<?= \fm\core\Db::$countSql?></div><!-- comment -->
    <div class="panel-body">
        <? foreach (\fm\core\Db::$queries as $v): ?>
            <?=$v?><br>
        <? endforeach; ?>
    </div><!-- comment -->
</div>
</div>
<?//=debug(\vendor\freedom\core\Db::$countSql);?>
<?//=debug(\vendor\freedom\core\Db::$queries);?>
<script src="/public/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/public/libs/jquery/jquery.js"></script>
    
    
<?


//if(!empty($scripts)){
//    foreach ($scripts as $script){
//        echo $script;
//    }
//}

// скрипты найденные в виде 
$this->addScripts();
?>
</body>
</html>

