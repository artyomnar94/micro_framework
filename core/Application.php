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
    private $response;
    
    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
    }
    
    /**
     * Routes request to controller action then returns response
     */
    public function run()
    {        
        $this->request->parseRequestUri();
        //$params = $this->request->parseGetParams();//I think this shit is useless        
        $controller = $this->request->getContoller();
        $this->request->callAction($controller);        
    }
    
}
