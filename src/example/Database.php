<?php

class Database {
    private $dbConnector;

    public function __construct(){
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["password"];
        $port = Config::$db["port"];

        $this->dbConnector = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");
    }
        public function query($query,...$params){
            $res = pg_query($this->dbConnector, $query, $params);
            if ( $res === false) {
                echo pg_last_error($this->dbConnector);
                return false;
        }
        return pg_fetch_all($res);
    }
}