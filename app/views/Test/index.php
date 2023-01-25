<hr>
<p>View: TEST->index</p>


<div style="max-width: 300px">
<!-- --><?php
//new \fm\widgets\menu\Menu([
//    'table' => 'categories',
//    'tpl' => 'select',
//    'container' => 'select',
//    'class' => 'form-select',
//    'debug' => true,
//    'cache' => 3600,
//    'cacheKey' => 'main-menu',
//    ]);
//?><!--   -->
</div>


<?php
new \fm\widgets\menu\Menu([
    'table' => 'categories',
    //'tpl' => 'default',
    'container' => 'ul',
    'class' => 'main-menu',
    'debug' => true,
    'cache' => false,
    'cacheKey' => 'main-menu2',
    ]);
?>



<div class="container">
    
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
<!--        <a class="nav-link active" aria-current="page" href="#">Home</a>
        <a class="nav-link" href="#">Features</a>
        <a class="nav-link" href="#">Pricing</a>
        <a class="nav-link disabled">Disabled</a>-->
        <?php /* foreach($menu as $link): ?>
            <a class="nav-link" href="#"><?=$link['title']?></a>
        <? endforeach; */?>
      </div>
    </div>
  </div>
</nav>

    
    
    
    <?php if(!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php echo $post['title']?>
                </div>
                <div class="panel-body">
                    <?php echo $post['text']?>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif; ?>
</div>


<hr>

<button class="btn btn-primary mybtn" id="send">Отправить</button>


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