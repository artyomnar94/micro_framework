<?php

namespace core\models;

/**
 * Description of BaseModel
 *
 * @author artyomnar
 */
class BaseModel {
    private $modelName;

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
        $isValidModel = true;
        foreach ($rules as $rule) {
            $attributeList = $rule[0];
            $isCustomValidator = strpos($rule[1], "\\");
            $validatorName = ($isCustomValidator === false)? ("\core\\validators\\" . ucfirst($rule[1]) . "Validator") : $rule[1];
            $params = $rule[2]?? [];
            
            /**
             * @param \core\validators\BaseValidator $validator
             */
            $validator = new $validatorName();            
            $isValidModel = $validator->isValid($this, $attributeList, $params);
            if (!$isValidModel) {
                return false;
            }
        }
        return true;
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
