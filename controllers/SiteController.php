<?php

namespace controllers;

use core\BaseController;
/**
 * Description of SiteController
 *
 * @author artyomnar
 */
class SiteController extends BaseController {
    
    public function actionIndex()
    {      
        $task = new \models\Task('Bob', 'asd@sd.sd', 'to do list', 1);        
                
        $this->view->render('index', ['task' => $task]);
    }
          
}
