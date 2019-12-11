<?php

namespace core;

use controllers\SiteController;
use core\Request;

/**
 * Base class for web app
 *
 * @author artyomnar
 */
class Application {
    
    private $request;
    
    public function __construct() {
        $this->request = new Request();
    }
    
    /**
     * Routes request to controller
     */
    public function route()
    {
        $this->request->parseRequestUri();
        $params = $this->request->parseGetParams();//I think this shit is useless
        
        $controller = $this->request->getContoller();
        $this->request->callAction($controller);
        
        //ToDo: create response class with inner logic
        $response = $controller->actionIndex($params);
        
        $this->render($response);
    }
    
    /**
     * Prints response view of action
     * @param array $response
     */
    public function render(array $response)
    {
        //[$view, $params] = $response;
        
        $view = $response['view'];
        $viewPath = "views/{$view}.php";
        //ToDo: provide params from response into view
        echo file_get_contents($viewPath);
    }
}
