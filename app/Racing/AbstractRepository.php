<?php
 
namespace Racing;
 
use Racing\Database\ConnectMySql;
 
abstract class AbstractRepository
{
    protected $db;
 
    public function __construct()
    {
        $connect = ConnectMySql::getInstance();
        $this->db = $connect->getPDO();
    }
}
