<?php

namespace controllers;

/**
 * Description of SiteController
 *
 * @author artyomnar
 */
class SiteController {
    
    public function actionIndex(): array
    {
        $task = new \models\Task();
        $response = ['view' => 'main', 'params' => ['task' => $task]];
        
        return $response;
    }
          
}
