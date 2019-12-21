<?php

namespace core\validators;

/**
 * Description of StringValidator
 *
 * @author artyomnar
 */
class StringValidator extends BaseValidator
{
    public $min;
    public $max;
    public $length;
    
    /**
     * 
     * @param \core\models\BaseModel $model
     * @param type $attributeList
     * @param array $params
     * @return bool
     */
    public function validate (\core\models\BaseModel $model, array $attributeList, array $params = []): bool
    {
        $this->setParams($params);
        if ($this->validateParams()) {
            if (!is_null($this->length)) {
                return $this->checkLength($model, $attributeList);                
            }
            if (!is_null($this->min)) {
                $this->checkMin($model, $attributeList);                
            }
            if (!is_null($this->max)) {
                $this->checkMax($model, $attributeList);                
            }
            return $this->isValid;
        }           
    }
    
    /**
     * Set param items as validator attributes
     * @param array $params
     * @return void
     */
    private function setParams(array $params): void
    {
        $this->length = $params['length']?? null;
        $this->min = $params['min']?? null;
        $this->max = $params['max']?? null;              
    }
    
    /**
     * Validates provided params values
     * @return bool
     */
    private function validateParams(): bool
    {
        if (!is_null($this->length) && !is_int($this->length)) {
            return false;
        }
        if (!is_null($this->min) && !is_int($this->min)) {
            return false;
        }
        if (!is_null($this->max) && !is_int($this->max)) {
            return false;
        }
        return true;
    }
    
    /**
     * Compares model attribute length with provided validator length.
     * If values are equals then returns true else false.
     * 
     * @param \core\models\BaseModel $model
     * @param array $attributeList
     * @return bool
     */
    private function checkLength(\core\models\BaseModel $model, array $attributeList): bool
    {
        foreach ($attributeList as $attribute) {
            if (strlen($model->$attribute) !== $this->length) {
                $model->errorMessages[$attribute] = "The value length must be equals $this->length chars";
                $this->isValid = false;
            }
        }
        return $this->isValid;
    }
    
    /**
     * Compares  model attribute length less then provided validator min value.
     * 
     * @param \core\models\BaseModel $model
     * @param array $attributeList
     */
    private function checkMin(\core\models\BaseModel $model, array $attributeList): void
    {        
        foreach ($attributeList as $attribute) {
            if (strlen($model->$attribute) < $this->min) {
                $model->errorMessages[$attribute] = "The value length must contain min $this->min chars";
                $this->isValid = false;
            }
        }
    }
    
    /**
     * Compares model attribute length bigger then provided validator max value.
     * 
     * @param \core\models\BaseModel $model
     * @param array $attributeList
     */
    private function checkMax(\core\models\BaseModel $model, array $attributeList): void
    {        
        foreach ($attributeList as $attribute) {
            if (strlen($model->$attribute) > $this->max) {
                $model->errorMessages[$attribute] = "The value length must contain max $this->max chars";
                $this->isValid = false;
            }
        }
    }

}
