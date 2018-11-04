<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/api/__shared/utilities.php';

class Database {
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "StudChat";
    private $username = "root";
    private $password = "";
    public $conn;

    // get the database connection
    public function getConnection(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
          printJSON(array("error"=>"Failed to connect to database"), 503);
        }

        return $this->conn;
    }
}
?>
