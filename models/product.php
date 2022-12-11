<?php

class Product{
    private $conn;
    private $table_name = 'products';

    public $id;
    public $name;
    public $co2_value;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create(){
        $query = 'INSERT INTO '. $this->table_name. ' (name, co2_value) 
                    VALUES (:name, :co2_value);';

        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->co2_value = htmlspecialchars(strip_tags($this->co2_value));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':co2_value', $this->co2_value);

        if ($stmt->execute()){
            return true;
        }else{
            echo 'ERROR';
            return false;
        }

    }

    public function update(){
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                co2_value = :co2_value
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->co2_value = htmlspecialchars(strip_tags($this->co2_value));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':co2_value', $this->co2_value);

        if ($stmt->execute()){
            return true;
        }else{
            echo 'ERROR';
            return false;
        }
    }

    public function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}