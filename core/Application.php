<?php

namespace core;

use core\Request;
use core\db\DB;

/**
 * Base class for web app
 *
 * @author artyomnar
 */
class Application
{
    private $request;
    private $response;
    public static $db;

    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
        self::$db = new DB();
    }
    
    /**
     * Routes request to controller action then returns response
     */
    public function run()
    {        
        $this->request->parseRequestUri();
        $this->request->parseHeaders();
        //$params = $this->request->parseGetParams();//I think this shit is useless        
        $controller = $this->request->getContoller();
        $result = $this->request->callAction($controller);
        if ($result) {
            $this->response->setHeaders($this->request->getFormat());
            $this->response->send($result, $this->request->getFormat());
        }
    }
    
}
