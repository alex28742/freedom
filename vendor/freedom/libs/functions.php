<?php
    function dump($data, bool $die = false, bool $type = true):void{
        echo "<pre>"; if(!$type) var_dump($data); else print_r($data);
        echo "</pre>"; if($die) die();
    }
    
    function debug($data, bool $die = false, bool $type = true):void{
        dump($data, $die, $type);
    }

