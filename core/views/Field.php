<?php

namespace core\views;

use \core\models\BaseModel;

/**
 * Clas can render base html input items
 * @todo methods to render html 5 attributes
 * <input type="color">
 * <input type="date">
 * <input type="datetime-local">
 * <input type="email">
 * <input type="file">
 * <input type="hidden">
 * <input type="image">
 * <input type="month">
 * <input type="range">
 * <input type="search">
 * <input type="tel">
 * <input type="time">
 * <input type="url">
 * <input type="week">

 * @author artyomnar
 */
class Field
{
    private $model;
    private $attribute;

    /**
     * @param BaseModel $model
     * @param string $attribute
     */
    public function __construct(BaseModel $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    
    /**
     * Renders label for input
     * @param type $label
     * @return void
     */
    private function renderLabel($label): void
    {
        if ($label === '') {
            echo "<label>{$this->model->getAttributeLabel($this->attribute)}</label>";            
        } elseif ($label) {
            echo "<label>$label</label>";
        }    
    }


    /**
     * Renders text input with provided html params and label. 
     * Params provides via convention 'htmlAttr' => 'value', for example 'id'=>'foo'
     * If $label = false|null then label will not be render.
     * 
     * @param array $htmlParams
     * @param string|bool $label
     * @return void
     */
    public function textInput(array $htmlParams = [], $label = ''): void
    {        
        $this->renderLabel($label);
        $paramString = View::extractHtmlParams($htmlParams);
        echo "<input $paramString type=\"text\" name=\"{$this->model->getModelName()}[$this->attribute]\">";        
    }
    
    /**
     * Renders number input with provided html params and label. 
     * Params provides via convention 'htmlAttr' => 'value', for example 'id'=>'foo'
     * If $label = false|null then label will not be render.
     * 
     * @param array $htmlParams
     * @param string|bool $label
     * @return void
     */
    public function number(array $htmlParams = [], $label = ''): void
    {
        $this->renderLabel($label);
        $paramString = View::extractHtmlParams($htmlParams);
        echo "<input $paramString type=\"number\" name=\"{$this->model->getModelName()}[$this->attribute]\">";
    }
    
    /**
     * Renders button with provided html params and value. 
     * Params provides via convention 'htmlAttr' => 'value', for example 'id'=>'foo'
     *
     * @param string $value
     * @param array $htmlParams
     * @return void
     */
    public static function button(string $value = '', array $htmlParams = []): void
    {
        $paramString = View::extractHtmlParams($htmlParams);
        echo "<input $paramString type=\"button\" value=\"$value\">";
        
    }
    
    /**
     * Renders submit button with provided html params and value. 
     * Params provides via convention 'htmlAttr' => 'value', for example 'id'=>'foo'
     * 
     * @param string $value
     * @param array $htmlParams
     * @return void
     */
    public static function submit(string $value = '', array $htmlParams = []): void
    {
        $value = $value? $value : 'Send';
        $paramString = View::extractHtmlParams($htmlParams);
        echo "<input $paramString type=\"submit\" value=\"$value\">";        
    }
    
    /**
     * Renders radio list with provided items, html params and label. 
     * Params provides via convention 'htmlAttr' => 'value', for example 'id'=>'foo'
     * 
     * @param array $items
     * @param array $htmlParams
     * @param string|bool $label
     * @return void
     */
    public function radioList(array $items, array $htmlParams = [], $label = ''): void
    {
        $this->renderLabel($label);
        foreach ($items as $value => $label) {
            $paramString = View::extractHtmlParams($htmlParams);
            echo "<input $paramString type=\"radio\" name=\"{$this->model->getModelName()}[$this->attribute]\" value=\"$value\">$label";
        }        
    }
    
    /**
     * Renders checkbox list with provided items, html params and label. 
     * Params provides via convention 'htmlAttr' => 'value', for example 'id'=>'foo'
     * 
     * @param array $items
     * @param array $htmlParams
     * @param string|bool $label
     * @return void
     */
    public function checkBoxList(array $items, array $htmlParams = [], $label = ''): void
    {
        $this->renderLabel($label);
        foreach ($items as $value => $label) {
            $paramString = View::extractHtmlParams($htmlParams);
            echo "<input $paramString type=\"checkbox\" name=\"{$this->model->getModelName()}[$this->attribute]\" value=\"$value\">$label";
        }        
    }
    
    /**
     * Renders password input with provided html params and label. 
     * Params provides via convention 'htmlAttr' => 'value', for example 'id'=>'foo'
     * 
     * @param array $items
     * @param array $htmlParams
     * @param string|bool $label
     * @return void
     */
    public function password(array $htmlParams = [], $label = ''): void
    {
        $this->renderLabel($label);
        $paramString = View::extractHtmlParams($htmlParams);
        echo "<input $paramString type=\"password\" name=\"{$this->model->getModelName()}[$this->attribute]\">";   
    }
    
    /**
     * Renders reset button with provided html params and value. 
     * Params provides via convention 'htmlAttr' => 'value', for example 'id'=>'foo'
     * 
     * @param array $htmlParams
     * @param string|bool $label
     * @return void
     */
    public static function reset(array $htmlParams = [], $value = ''): void
    {     
        $value = $value? $value : 'Clear';
        $paramString = View::extractHtmlParams($htmlParams);
        echo "<input $paramString type=\"reset\" value=\"$value\">";   
    }                        
               
}
