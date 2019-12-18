<?php

namespace core\validators;

/**
 * Description of RequireValidator
 *
 * @author artyomnar
 */
class RequireValidator extends BaseValidator
{
    /**
     * Checks does provided attributes empty in current model
     * @param \core\models\BaseModel $model
     * @param array attributeList
     * @param array $params
     * @return boolean
     */
    public function validate (\core\models\BaseModel $model, array $attributeList, array $params = []): bool
    {                
        foreach ($attributeList as $attribute) {
            if (empty($model->$attribute)) {
                $this->isValid = false;
                $model->errorMessages[$attribute] = "$attribute can't by empty";
            }
        }
        return $this->isValid;
    }
}
