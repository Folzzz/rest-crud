<?php
    //Database class
    class Database {
        //*DB PARAMS
        private $host = "localhost";
        private $db_name = "myrestblog";
        private $username = "root";
        private $password= "";
        private $conn;

        //* METHOD TO DB CONNECT
        public function connect() {
            // SET CONNECTION PROPERTY TO NULL
            $this->conn = null;

            //CREATE A PDO OBJECT
            try{
                $this->conn = new PDO('mysql:host='. $this->host . ';dbname='. $this->db_name, $this->username, $this->password);
                //SET ERROR MODE TO KNOW WHEN ANYTHING GOES WRONG
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection Error: ".$e->getMessage();
            }

            return $this->conn;
        } 
    }
?>