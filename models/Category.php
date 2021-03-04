<?php
    //create category class
    class Category{
        private $conn; //connection
        private $table ='categories';

        //set categories properties
        public $id;
        public $name;
        public $created_at;

        //construct with database
        public function __construct($db) {
            $this->conn = $db;
        }

        //method to read category
        public function read() {
            //create query
            $query = "SELECT 
                        id, name, created_at 
                    FROM ". $this->table . 
                    " ORDER BY 
                        created_at DESC";
            
            //PREPARE STATEMENT
            $stmt = $this->conn->prepare($query);
            //execute statement
            $stmt->execute();

            return $stmt;

        }

        //method to read single category
        public function read_single(){
            //create query
            $query = "SELECT 
                        id, name, created_at FROM "
                        . $this->table . 
                    " WHERE id = ? 
                    LIMIT 0,1
                    ";

            //PREPARE STATEMENT
            $stmt = $this->conn->prepare($query);
            //bind id to $stmt
            $stmt->bindParam(1, $this->id);
            //execute statement
            $stmt->execute();

            //fetch array that will be returned
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //assign property
            $this->name = $row['name'];
            $this->created_at = $row['created_at'];
        }

        //method to create category
        public function create() {
            //create query
            $query = "INSERT INTO "
                        . $this->table . 
                    " SET
                            name = :name";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean up data
            $this->name = htmlspecialchars(strip_tags($this->name));

            //bind data
            $stmt->bindParam(':name', $this->name);

            //execute stmt
            if ($stmt->execute()) {
                return true;
            }
            //print error if something goes wrong
            printf("ERROR: %s.\n", $stmt->error);
            return false;
        }

        //method to update category
        public function update() {
            //create query
            $query = "UPDATE " . $this->table . " 
                        SET
                            name = :name
                        WHERE id = :id";
            
            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean up data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':id', $this->id);

            //execute query
            if($stmt->execute()) {
                return true;
            }
            //print error if anything goes wrong
            printf("ERROR: %s.\n", $stmt->error);
            return false;
        }

        //method to delete
        public function delete() {
            //create query
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind data
            $stmt->bindParam(':id', $this->id);

            //execute statement
            if ($stmt->execute()) {
                return true;
            }
            //print error incase
            printf("ERROR: %s.\n", $stmt->error);
            return false;
        }
    }
?>