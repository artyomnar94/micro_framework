<?php

namespace core\views;

use \core\models\BaseModel;

/**
 * Description of Form
 *
 * @author artyomnar
 */
class Form
{
    private $method;
    private $action;
    private $model;
    private $htmlParams;


    public function __construct(BaseModel $model, string $action, string $method = 'post', array $htmlParams = [])
    {
        $this->model = $model;
        $this->action = $action;
        $this->method = $method;
        $this->htmlParams = $htmlParams;

        $this->start();
    }
    
    /**
     * Renders form start
     * @return void
     */
    private function start(): void
    {
        $paramString = View::extractHtmlParams($this->htmlParams);
        echo "<form method=\"$this->method\" action=\"$this->action\" $paramString>";
    }
    
    /**
     * Renders form end
     * @return void
     */
    public function end(): void
    {
         echo "</form>";
    }
    
    /**
     * 
     * @param string $attribute - model attrubite to build input field, label etc
     * @throws Exception - if provided attributes doesn't exist in current model
     * @return \core\views\Field
     */
    public function field(string $attribute): Field
    {
        if (property_exists($this->model, $attribute)) {            
            return new Field($this->model, $attribute);
        } else {
            $modelClass = get_class($this->model);
            \core\Response::getErrorPage(402, "Unknown poperty $attribute of model $modelClass");
        }
    }
}
