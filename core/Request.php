<?php

namespace core;

/**
 * class Request contains methods to parse input uri and get params
 *
 * @author artyomnar
 */
class Request
{
    private $controller;
    private $action;
    private $getParams = [];
    private $format;
    private $headers = [];

    /**
     * Parses current request uri and sets contoller and action value
     */            
    public function parseRequestUri(): void
    {
        $uri = substr($_SERVER['REQUEST_URI'], 1);
        $queryString = $_SERVER['QUERY_STRING'];
        if ($queryString) {
            $uri = str_replace('?', '', strstr($uri, $queryString, true));            
        }   
        $routeParams = explode('/', $uri);
        $this->controller = $routeParams[0]? $routeParams[0] : 'site';
        $this->action = $routeParams[1]?? 'index';
    }
    
    /**
     * Parses request headers to define response format
     */
    public function parseHeaders(): void
    {
        $this->headers = getallheaders();
        $this->format = $this->headers['Content-Type']?? 'text/html';
    }

    /**
     * Parses query string and returns get parameters as list
     * @return array
     */
    public function parseGetParams(): array
    {
        $queryString = $_SERVER['QUERY_STRING'];
        if ($queryString) {
            $rawParams = explode('&', $queryString);
            $getParams = [];
            foreach ($rawParams as $param) {
                $key = strstr('=', $param, true);
                $value = substr(strstr('=', $param), 1);
                $getParams[$key] = $value;
            }        
            $this->getParams = $getParams;
        }
       
        return $this->getParams;
    }
    
    /**
     * Defines controller and returns reflection object
     * @return \ReflectionClass
     */
    public function getContoller(): \ReflectionClass
    {
        $contollerClassName = '\controllers\\' . ucfirst($this->controller) . 'Controller';
        try {
            $contollerReflection = new \ReflectionClass($contollerClassName);
        } catch (\Throwable $ex) {
            Response::getErrorPage(404, 'Page not found'); //Uncatching 404 exception!!! Throwable flag is ignored!
        }
        return $contollerReflection;
    }
    
    /**
     * Executes action of reqested controller
     * @param \ReflectionClass $contoller
     * @return mixed
     */
    public function callAction(\ReflectionClass $contoller)
    {
        $actionMethod = 'action' . ucfirst($this->action);
        try {
            return $contoller->getMethod($actionMethod)->invoke($contoller->newInstance($this->controller, $this->format));
        } catch (\ReflectionException $exception) {          
            Response::getErrorPage(404, 'Page not found');//Unavailable to provide custom error view, cause calling function inside core dir
        }
    }
    
    /**
     * Returns contoller name how specify in URL
     * @return string
     */
    public function getControllerName(): string
    {
        $controllerName = strtolower($this->controller);
        return $controllerName;
    }
    
    /**
     * Returns get parameters as list in current request
     * @return array
     */
    public function getParams(): array
    {
        return $this->getParams;
    }
    
    /**
     * Redirects current request to provided url
     * @param string $url
     */
    public function redirect(string $url)
    {
        header("location: $url");
        exit;
    }
    
    /**
     * Returns response format
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }
}
