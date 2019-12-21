<?php

namespace core\models;

/**
 * Description of BaseModel
 *
 * @author artyomnar
 */
class BaseModel
{
    private $modelName;
    
    /**
     * Stores errors after attribute validation in format 'attr' => 'error msg'
     * @var array $errorMessages
     */
    public $errorMessages = [];

    public function __construct() {
        $modelPathItems = explode('\\', __CLASS__);
        $this->modelName = $modelPathItems[count($modelPathItems) - 1];        
    }

    /**    
     * @return string
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }        

    /**
     * Set rules to validate model attributes.
     * There is an convention:
     * [
     *      [attributeList], //string or array of strings
     *      validatorName, //string with namespacing if custom validator used else without
     *      [param1 => val1, ...] //array where provided param name as a key with value to configure validator 
     * ]
     * 
     * @return array
     */
    public function rules(): array
    {
        return [];        
    }
    
    /**
     * Returns attribute labels as array 'attr' => 'attr name' wish used in forms, errors
     * @return array
     */
    public function getAttributeLabels(): array
    {
        return [];
    }
    
    /**
     * Returns label by provided model attribute or attribute name if value doesn't exists 
     * @param string $attribute
     * @return string
     */
    public function getAttributeLabel(string $attribute): string
    {
        $labelList = $this->getAttributeLabels();
        return $labelList[$attribute]?? $attribute;
    }

        /**
     * Set model attribute values from provided container if used convention
     * 'modelName' => ['attributeName' => 'value']
     * @param array $container
     */
    public function load(array $container)
    {        
        if (isset($container[$this->modelName])) {            
            foreach ($container[$this->modelName] as $key => $value) {
                $this->$key = $value;
            }
        }
    }
    
    /**
     * Validates model attributes using rules() content
     * @return bool
     */
    public function validate(): bool
    {
        $rules = $this->rules();
        $validationResults = [];
        foreach ($rules as $rule) {
            $attributeList = $rule[0];
            if (!is_array($attributeList)) {
                $attributeList = [$attributeList];
            }
            $isCustomValidator = strpos($rule[1], "\\");
            $validatorName = ($isCustomValidator === false)? ("\core\\validators\\" . ucfirst($rule[1]) . "Validator") : $rule[1];
            $params = $rule[2]?? [];
            
            /**
             * @param \core\validators\BaseValidator $validator
             */
            $validator = new $validatorName();            
            $validationResults[$validatorName] = $validator->validate($this, $attributeList, $params);
        }
        
        return in_array(false, $validationResults)? false : true;
    }
      
    /**public function getAttributeList(array $attributes = []): array
    {
        $attrList = [];
        if (empty($attributes)) {
            
        } else {
            foreach ($attributes as $item) {
                $attrList[$item] = $this->$item;
            }
        }
    }*/
         
}
