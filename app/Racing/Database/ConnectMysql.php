<?php

namespace Racing\Database;
use Racing\GenericSingleton;

class ConnectMysql extends GenericSingleton
{
    private $pdo;

    protected function __construct()
    {
        $config = include dirname(__DIR__, 2).'/config.php';
        $this->pdo = new \PDO($config['mysql']['dsn'], 
        $config['mysql']['username'], $config['mysql']['password']);
    }

    public function getPDO() 
    {
        return $this->pdo;
    }

}