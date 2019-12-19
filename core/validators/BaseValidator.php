<?php

namespace core\validators;

/**
 * Description of BaseValidator
 *
 * @author artyomnar
 */
abstract class BaseValidator
{
    public $attribte;
    public $isValid = true;
    
    /**
     * Validates provided attribute whith rule parameters
     * @param \core\models\BaseModel $model
     * @param array $attributeList
     * @param array $params
     * @return bool
     */
    public abstract function validate (
            \core\models\BaseModel $model, 
            array $attributeList,
            array $params = []
            ): bool;
}
