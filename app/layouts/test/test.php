<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Template</title>
    <link href="/public/libs/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style>
        body { background: lightcoral}
    </style>
</head>
<body>
<h1>Test Template</h1>

<?=$content;?>


<script src="/public/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/public/libs/jquery/jquery.js"></script>

<? // скрипты найденные в виде 
if(!empty($scripts)){
    foreach ($scripts as $script){
        echo $script;
    }
}
?>



</body>
</html>

