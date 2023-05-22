<hr>
<p>View: TEST->index</p>





<?php

//new \fm\widgets\menu\Menu([
//    'table' => 'categories',
//    //'tpl' => 'default',
//    'container' => 'select',
//    'class' => 'main-menu',
//    'debug' => false,
//    'cache' => false,
//    'cacheKey' => 'main-menu2',
//    ]);
//?>

<? new \fm\widgets\menu\Menu([
    'table' => 'categories', // таблица с ключами id, title, parent, alias
    'tpl' => 'default', // шаблон по пути vendor/freedom/widgets/menu/tpl/
    'container' => 'select', // обертка (ul or select. ul - по умолчанию)
    'class' => 'menu', // класс для обертки
    'cache' => false, // время кеширования (если передать false - кешир. откл)
    'cacheKey' => 'test-menu', // уникальный идентификатор, напр. (main-menu)
    'debug' => false, // протоколирование обращений к БД
]);?>


<div class="container">
    
    <? $this->IncludeFile('navbar');  ?>


    <?php if(!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <?// dump($post, true);?>
            <div class="content-grid-info">
                <img src="<?=$this->template;?>/images/post1.jpg" alt=""/>
                <div class="post-info">
                    <h4><a href="<?=$this->template;?>/single.html">link</a><?=$post['title']?></h4>
                    <p><?=$post['excerpt']?></p>
                    <a href="<?=$this->template;?>/single.html"><span></span><?= \fm\core\base\Lang::get("recent_posts");?></a>
                </div>
            </div>
        <?php endforeach;?>
        <?
            // выводим пагинацию только если у нас больше 1 страницы
            if($pagination->totalPages > 1){
                echo $pagination;
            }
        ?>
    <?php endif; ?>
</div>


<hr>

<div class="result_error"></div>
<div class="result"></div>
<form class='form ajax' action='/test/form' method='post'>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
        <div id="emailHelp" class="form-text">Мы никогда никому не передадим вашу электронную почту.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Проверить меня</label>
    </div>
    <button type="submit" class="btn btn-primary">Отправить</button>
</form>
<br>
<!--<button class="btn btn-primary mybtn" id="send">Отправить</button>-->





<script>
    
    $(function(){
       $('.mybtn').on('click', function(){
        $.ajax({   
             url: '/test/ajax', // куда будет идти запрос
             type: 'post', // метод передачи данных
             data: {'id':2}, // данные которые хотим получить
             success: function(res){ // что делаем при получении ответа
                 console.log(res);
             },
             error: function(){ // если возникла ошибка
                 alert('error');
             }
         });   
        }); 
    });
    
    

</script>

<script src="/public/libs/js/ajax.js"></script>