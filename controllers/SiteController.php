<?php

namespace controllers;

use core\controllers\BaseController;
use models\Task;

/**
 * Description of SiteController
 *
 * @author artyomnar
 */
class SiteController extends BaseController
{
    
    public function actionIndex()
    {      
        $task = new Task();
        $task->load($_POST);
        $isValid = $task->validate();
        $users = new \models\Users();
        //$res = $users->select(['name'])->findWhere(['id' => 3])->getAll();
        $res = $users->findOne(4);
        $this->view->render('index', ['task' => $task, 'isValid' => $isValid, 'res' => $res]);
    }
          
}
