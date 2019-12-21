<?php

namespace core\views;

/**
 * Description of View
 *
 * @author artyomnar
 */
class View
{
    public $view;
    public $viewPath;
    public $layout;
    public $layoutPath;
    public $controllerId;  
    
    /**
     * Renders view with layout
     * 
     * @param string $view
     * @param array $params
     * @param string $layout
     */
    public function render(string $view, array $params = [], string $title = '', string $layout = 'default')
    {
        $this->layout = $layout;
        $this->layoutPath = "views/layouts/{$this->layout}.php";
        $this->view = $view;
        $this->viewPath = "views/{$this->controllerId}/{$this->view}.php";
       
        $title = empty($title)? ("{$this->controllerId}/{$this->view}") : $title;
        extract($params);
        
        ob_start();
        require $this->viewPath;
        $content = ob_get_clean();
        require $this->layoutPath;
    }
    
    /**
     * Renders view without layout
     * 
     * @param string $view
     * @param array $params
     * @param string $title
     */
    public function renderPartial(string $view, array $params = [], string $title = '') {
        $this->view = $view;
        $this->viewPath = "views/{$this->controllerId}/{$this->view}.php";
       
        $title = empty($title)? ("{$this->controllerId}/{$this->view}") : $title;
        extract($params);        
        require $this->viewPath;
    }
    
    /**
     * Returns unpacked html attributes as string
     * @param array $params
     * @return string
     */
    public static function extractHtmlParams(array $params): string
    {
        $paramstring = '';
        foreach ($params as $key => $val) {
            $paramstring .= " $key=\"$val\"";
        }
        return $paramstring;
    }   
}
