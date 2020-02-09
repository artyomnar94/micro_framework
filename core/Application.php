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

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        self::$db = new DB();
    }
    
    /**
     * Routes request to controller action then returns response
     */
    public function run()
    {
        try {
            $this->request->parseRequestUri();
            $this->request->parseHeaders();
            //$params = $this->request->parseGetParams();//I think this shit is useless        
            $controller = $this->request->getContoller();
            $result = $this->request->callAction($controller);
            if ($result) {
                $this->response->setHeaders($this->request->getFormat());
                $this->response->send($result, $this->request->getFormat());
            }
        } catch (\Throwable $e) {
            $this->displayError($e);
        }
    }
    
    /**
     * Prints error info
     * @param \Throwable $error
     */
    private function displayError(\Throwable $error)
    {
        echo "<h1>Ooooops</h1>";
        echo "<h2>Code: {$error->getCode()}";
        echo "<h2>File: {$error->getFile()}";
        echo "<h2>Line: {$error->getLine()}";
        echo "<pre>{$error->getMessage()}</pre>";
        echo "<h3>Stack Trace:</h3><pre>";
        print_r($error->getTrace());
        echo "</pre>";
        die;
    }
          
}
