<?php

namespace core\models;

/**
 * class ActiveModel contain logic for working with DB using Table-entity
 *
 * @author artyomnar
 */
class ActiveModel extends BaseModel
{
    protected $tableName;
    private $db;
    private $queryString;
    private $selectPart = "";
    private $conditionPart = "";
    private $conditionParams = [];

    public function __construct()
    {
        parent::__construct();
        $this->db = new \core\db\DB();
        $this->tableName = $this->modelName;
    }
    
    /**
     * Returns all table rows as array
     * @return type
     */
    public function getAll()
    {
        $this->queryString = empty($this->selectPart)? "SELECT * FROM {$this->tableName}" : ($this->selectPart . " FROM {$this->tableName} " . $this->conditionPart);
        //var_dump([$this->queryString, $this->conditionParams]);die;
        $rows = $this->db->row($this->queryString, $this->conditionParams);        
        return $rows;
    }
    
    /**
     * Builds select part of query
     * @param array $colls
     * @return ActiveModel
     */
    public function select(array $colls = []): ActiveModel
    {
        $this->selectPart = "SELECT ";
        if ($colls) {
            foreach ($colls as $item) {
                $this->selectPart .= "$item,";
            }
            $this->selectPart = substr($this->selectPart, 0, strlen($this->selectPart) - 1);
        } else {
            $this->selectPart .= ' *';
        }
        return $this;
    }
    
    /**
     * Builds filter part of query
     * @param array $condition     
     * @return ActiveModel
     */
    public function findWhere(array $condition): ActiveModel
    {
        if (!$this->selectPart) {
            $this->select();
        }
        $this->conditionPart = " WHERE ";
        $this->conditionParams = $this->getCondParams($condition);
        foreach ($condition as $key => $val) {
            $this->conditionPart .=  "$key = :$key,";
        }
        $this->conditionPart = substr($this->conditionPart, 0, strlen($this->conditionPart) - 1);
        return $this;
    }
    
    /**
     * Concats prefix on parameter keys for save sql execution
     * @param array $params
     * @return array
     */
    private function getCondParams(array $params): array
    {
        $result = [];
        foreach ($params as $key => $val) {
            $result[":$key"] = $val;
        }
        return $result;
    }
    
    public function findOne($attribute)
    {
        if (!is_array($attribute)) {
            $condition = ['id' => $attribute];
        }
        $result = $this->findWhere($condition)->getAll();
        return $result;        
    }
    
}
