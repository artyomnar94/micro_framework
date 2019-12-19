<?php

namespace core\controllers;

/**
 * Description of BaseController
 *
 * @author artyomnar
 */
class BaseController
{
    public $id;
    public $view;
    
    /**
     * 
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
        $this->view = new \core\views\View();
        $this->view->controllerId = $id;
    }
}
