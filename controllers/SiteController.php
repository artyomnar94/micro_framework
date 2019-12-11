<?php

namespace controllers;

/**
 * Description of SiteController
 *
 * @author artyomnar
 */
class SiteController {
    
    public function actionIndex()//: array
    {
        var_dump(123); die;
        $task = new \models\Task();
        $response = ['view' => 'main', 'params' => ['task' => $task]];
        
        return $response;
    }
          
}
