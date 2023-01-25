<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ошибка</title>
</head>
<body>
    <div class="container">
        <h1>Произошла ошибка</h1>
        <p><b>Код ошибки:&nbsp;</b><code><?=$errno ?></code></p>
        <p><b>Текст ошибки:&nbsp;</b><code><?=$errstr ?></code></p>
        <p><b>Файл:&nbsp;</b><code><?=$errfile ?></code> <b>Строка:&nbsp;</b> <code><?=$errline?></code></p>
    </div>  
</body>
</html>