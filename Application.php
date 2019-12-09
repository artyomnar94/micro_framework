<?php

use controllers\SiteController;

/**
 * Base class for web app
 *
 * @author artyomnar
 */
class Application {
    /**
     * Routes request to controller
     */
    public function route()
    {
        //define required controller and action
        //should dinamically create required controller and call action method inside this one
        //Also should create several main objects: request, response classes
        $controller = new SiteController();
        $response = $controller->actionIndex();
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
