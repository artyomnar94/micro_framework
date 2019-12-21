<?php

namespace core\validators;

/**
 * Description of NumberValidator
 *
 * @author artyomnar
 */
class NumberValidator extends BaseValidator
{    
    public $min;
    public $max;
    
    /**    
     * @param \core\models\BaseModel $model
     * @param type $attributeList
     * @param array $params
     * @return bool
     */
    public function validate (\core\models\BaseModel $model, array $attributeList, array $params = []): bool
    {
        $this->setParams($params);
        if ($this->validateParams()) {
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
        $this->min = $params['min']?? null;
        $this->max = $params['max']?? null;              
    }
    
    /**
     * Validates provided params values
     * @return bool
     */
    private function validateParams(): bool
    {        
        if (!is_null($this->min) && !is_numeric($this->min)) {
            return false;
        }
        if (!is_null($this->max) && !is_numeric($this->max)) {
            return false;
        }
        return true;
    }
    
    /**
     * Compares  model attribute value less then provided validator min value.
     * 
     * @param \core\models\BaseModel $model
     * @param array $attributeList
     */
    private function checkMin(\core\models\BaseModel $model, array $attributeList): void
    {        
        foreach ($attributeList as $attribute) {
            if ($model->$attribute < $this->min) {
                $model->errorMessages[$attribute] = "The value can't be less than $this->min";
                $this->isValid = false;
            }
        }
    }
    
    /**
     * Compares model attribute value bigger then provided validator max value.
     * 
     * @param \core\models\BaseModel $model
     * @param array $attributeList
     */
    private function checkMax(\core\models\BaseModel $model, array $attributeList): void
    {        
        foreach ($attributeList as $attribute) {
            if ($model->$attribute > $this->max) {
                $model->errorMessages[$attribute] = "The value ca't be greater than $this->max";
                $this->isValid = false;
            }
        }
    }

}
