<?php

namespace app\controllers;

/**
 * Description of PostsController
 *
 * @author als
 */
class PostsController extends AppController {
    
    
    public function indexAction(){
        echo __METHOD__;
        $this->model = new \app\models\Posts;
    }
}
