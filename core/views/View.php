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
     * Renders form to set model property
     * 
     * @param \core\BaseModel $model
     * @param string $action
     * @param string $method
     * @param array $attributeList
     */
    public static function renderForm(
            \core\models\BaseModel $model, 
            string $action, 
            string $method = 'POST', 
            array $attributeList = []
            )
    {
        $modelName = $model->getModelName();
        echo "<form method=\"$method\" action=\"$action\">";
        //$attributeList = empty($attributeList)? $model-> //ToDo: realize getting all model attributes by default or provided
        foreach ($attributeList as $item) {
            echo "<label>$item</label>";
            //echo "<input type=\"text\" name=\"$modelName'['$item']'\">";
            echo "<input type=\"text\" name=\"$modelName";
            echo "[$item]\">";
        }
        echo "<input type=\"submit\">";
        echo "</form>";        
    }
}
