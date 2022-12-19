<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'kreas_db';
    private $username = 'root';
    private $password = 'armandosql';
    public $conn;

    public function connect(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host="
                .$this->host .";dbname=".$this->db_name,
                $this->username,
                $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exceprion){
            echo "Connection Error". $exceprion;
        }
        return $this->conn;
    }
}