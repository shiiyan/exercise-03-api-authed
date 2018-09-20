<?php
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

$Pdo =  new PdoMysql(
        [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'myusers'
        ]
    );

//return $Pdo;