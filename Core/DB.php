<?php

namespace Core;

class DB
{
    public $connect;

    protected const DB_HOST = 'mvc.oop';
    protected const DB_DATABASE_NAME = 'mvc';
    protected const DB_USER = 'mysql';
    protected const DB_PASS = '';

    public function __construct()
    {
        $dsn = 'mysql:host='.self::DB_HOST.';dbname='.self::DB_DATABASE_NAME;
        $this->connect = new \PDO($dsn, self::DB_USER, self::DB_PASS);
    }
}