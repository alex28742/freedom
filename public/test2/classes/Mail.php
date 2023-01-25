<?php

namespace classes;
/**
 * Description of Mail
 *
 * @author als
 */
class Mail {
    
    public function __construct() {
        echo __METHOD__;
    }
    
    public function go(){
        echo "Поехали";
    }
}
