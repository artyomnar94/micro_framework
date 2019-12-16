<?php

namespace core\validators;

/**
 * Description of BaseValidator
 *
 * @author artyomnar
 */
abstract class BaseValidator {
    public $attribte;
    
    /**
     * Validates provided attribute whith rule parameters
     * @param \core\BaseModel $model
     * @param string|array $attributeList
     * @param array $params
     * @return bool
     */
    public abstract function isValid(\core\BaseModel $model, $attributeList, array $params = []): bool;    
}
