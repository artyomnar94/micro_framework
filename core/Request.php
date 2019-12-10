<?php

namespace core;

/**
 * Description of Request
 *
 * @author artyomnar
 */
class Request {
    private $controller;
    private $action;
    private $getParams = [];
    
    /**
     * Parses current request uri and sets contoller and action value
     */            
    public function parseRequestUri()
    {
        $rawUri = substr($_SERVER['REQUEST_URI'], 1);
        $queryString = $_SERVER['QUERY_STRING'];
        $uri = str_replace('?', '', strstr($rawUri, $queryString, true));
        
        $routeParams = explode('/', $uri);
        $this->controller = $routeParams[0];
        $this->action = $routeParams[1]?? 'index';        
    }
    
    /**
     * Parses query string and returns get parameters as list
     * @return array
     */
    public function parseGetParams(): array
    {
        $queryString = $_SERVER['QUERY_STRING'];
        $rawParams = explode('&', $queryString);
        $getParams = [];
        foreach ($rawParams as $param) {
            $key = strstr('=', $param, true);
            $value = substr(strstr('=', $param), 1);
            $getParams[$key] = $value;
        }
        
        $this->getParams = $getParams;
        return $getParams;
    }
    
    public function getContoller(): \ReflectionClass
    {
        $contollerClassName = '\controllers\\' . ucfirst($this->controller) . 'Controller';
        $contollerReflection = new \ReflectionClass($contollerClassName);
        
        //$actionMethod = 'action' . ucfirst($this->action);
        //$object->getMethod($actionMethod)->invoke($object->newInstance());        
        //return $object->newInstance();
        
        return $contollerReflection;
    }
    
    public function callAction(\ReflectionClass $contoller)
    {
        $actionMethod = 'action' . ucfirst($this->action);
        $contoller->getMethod($actionMethod)->invoke($contoller->newInstance());
    }
    
    /**
     * Returns get parameters as list in current request
     * @return array
     */
    public function getParams(): array
    {
        return $this->getParams;
    }
}
