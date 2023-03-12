<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE HTML>
<html>
<head>
    <? \fm\core\base\View::getMeta(); ?>
    <link href="/public/libs/bootstrap/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?=$this->template;?>/css/style.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!----webfonts---->
    <link href='http://fonts.googleapis.com/css?family=Oswald:100,400,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic' rel='stylesheet' type='text/css'>
    <!----//webfonts---->

</head>
<body>
<!---header---->
<div class="header">
    <div class="container">
        <div class="logo">
            <a href="/"><img src="<?=$this->template;?>/images/logo.jpg" title="" /></a>
        </div>
        <!---start-top-nav---->
        <div class="top-menu">
            <div class="search">
                <form>
                    <input type="text" placeholder="" required="">
                    <input type="submit" value=""/>
                </form>
            </div>
            <span class="menu"> </span>
            <ul>
                <li class="active"><a href="<?=$this->template;?>/index.html">HOME</a></li>
                <li><a href="<?=$this->template;?>/about.html">ABOUT</a></li>
                <li><a href="<?=$this->template;?>/contact.html">CONTACT</a></li>
                <div class="clearfix"> </div>
            </ul>
        </div>
        <div class="clearfix"></div>

        <!---//End-top-nav---->
    </div>
</div>
<!--/header-->
<div class="content">
    <div class="container">
        <div class="content-grids">
            <div class="col-md-8 content-main">
                <div class="content-grid">
                    <?=$content?>
<!--                    <div class="content-grid-info">-->
<!--                        <img src="--><?php //=$TEMPLATE?><!--/images/post1.jpg" alt=""/>-->
<!--                        <div class="post-info">-->
<!--                            <h4><a href="--><?php //=$TEMPLATE?><!--/single.html">Lorem ipsum dolor sit amet</a>  July 30, 2014 / 27 Comments</h4>-->
<!--                            <p>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis.</p>-->
<!--                            <a href="--><?php //=$TEMPLATE?><!--/single.html"><span></span>READ MORE</a>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="col-md-4 content-right">
                <?php
                new \fm\widgets\menu\Menu([
                    'table' => 'categories',
                    'tpl' => 'default',
                    'container' => 'select',
                    'class' => 'main-menu',
                    'debug' => false,
                    'cache' => false,
                    'cacheKey' => 'main-menu2',
                ]);
                ?>
                <? $this->IncludeFile("sidebar"); ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!---->
<div class="footer">
    <div class="container">
        <p>Copyrights © 2015 Blog All rights reserved | Template by <a href="/">W3layouts</a></p>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--end slider -->
<!--script-->
<script type="text/javascript" src="<?=$this->template;?>/js/move-top.js"></script>
<script type="text/javascript" src="<?=$this->template;?>/js/easing.js"></script>
<!--/script-->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},900);
        });
    });

    $("span.menu").click(function(){
        $(".top-menu ul").slideToggle("slow" , function(){
        });
    });

</script>

<?
// скрипты найденные в виде
$this->addScripts();
?>
</body>
</html>



