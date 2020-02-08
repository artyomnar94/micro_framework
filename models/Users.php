<?php

namespace models;

use \core\models\ActiveModel;
/**
 * Description of Users
 *
 * @author artyomnar
 */
class Users extends ActiveModel
{
    public $id;
    public $name;
    
    public function __construct() {
        parent::__construct();
        $this->tableName = 'users';
    }
}
