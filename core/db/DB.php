<?php

namespace core\db;

use \PDO;
/**
 * Class for working with DB
 *
 * @author artyomnar
 */
class DB
{
    protected $db;
    
    public function __construct()
    {
        $config = (require 'config/main.php')['db'];        
        $this->db = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                $config['user'],
                $config['password'],
            );                   
    }
    
    public function query(string $sql, array $params = [])
    {
        //SQL - injection save query
        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        return $statement;
    }
    
    
    public function row(string $sql, array $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function column(string $sql, array $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}
