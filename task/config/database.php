<?php

class Database{
    private $conn;

    public function getConnection(){
        $this->conn=new mysqli("localhost","root","","post_management");
        if($this->conn->connect_error){
            die("Conection error".$this->conn);
        }

        return $this->conn;
    }
}