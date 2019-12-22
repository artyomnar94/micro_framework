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
    public $responseFormat;

    /**
     * 
     * @param string $id
     */
    public function __construct(string $id, $format = 'text/html')
    {
        $this->id = $id;
        $this->view = new \core\views\View();
        $this->view->controllerId = $id;
        $this->responseFormat = $format;
    }
}
