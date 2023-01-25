<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <? \fm\core\base\View::getMeta(); ?>
    <link href="/public/libs/bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    стили шаблона-->
    <link rel="stylesheet" href="/public/css/layouts/<?=$this->layout?>.css">
<!--    общие стили проекта -->
    <link rel="stylesheet" href="/public/css/main.css">
</head>
<style>
    body{ background: lightblue; }
</style>
<body>
<h1>Default Template</h1>

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
