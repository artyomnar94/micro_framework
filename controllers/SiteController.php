<?php

namespace controllers;

use core\controllers\BaseController;
use models\Task;
/**
 * Description of SiteController
 *
 * @author artyomnar
 */
class SiteController extends BaseController {
    
    public function actionIndex()
    {      
        $task = new Task();
        $task->load($_POST);
        //var_dump($_POST);
        $isValid = $task->validate();
                
        $this->view->render('index', ['task' => $task, 'isValid' => $isValid]);
    }
          
}
