<?php

namespace core\validators;

/**
 * Description of RequireValidator
 *
 * @author artyomnar
 */
class RequireValidator extends BaseValidator {
    /**
     * Checks does provided attributes empty in current model
     * @param \core\BaseModel $model
     * @param string | array attributeList
     * @param array $params
     * @return boolean
     */
    public function isValid(\core\BaseModel $model, $attributeList, array $params = []): bool
    {        
        if (is_string($attributeList)) {
            return empty($model->$attributeList)? false : true;
        } elseif (is_array($attributeList)) {
            foreach ($attributeList as $attribute) {                
                if (empty($model->$attribute)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}
