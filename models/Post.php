<?php
    class Post {
        //DB STUFFS
        private $conn; //REPRESENTING CONNECTION
        private $table = 'posts';

        //*SET POST PROPERTIES
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // CONSTRUCTOR WITH DB
        public function __construct($db){
            $this->conn = $db;
        }

        //METHOD TO GET/READ POST
        public function read() {
            //CREATE QUERY
            $query = 'SELECT 
                        c.name as category_name,
                        p.id,
                        p.category_id,
                        p.title,
                        p.body,
                        p.author,
                        p.created_at
                    FROM ' . $this->table . ' p
                    LEFT JOIN
                        categories c ON p.category_id = c.id
                    ORDER BY
                        p.created_at DESC
                    ';

            //*CREATE PREPARE STATEMENT
            $stmt = $this->conn->prepare($query);
            //EXECUTE STATEMENT
            $stmt->execute();

            return $stmt;
        }

        //METHOD TO GET SINGLE POST
        public function read_single() {
            //CREATE QUERY
            $query = 'SELECT
                        c.name as category_name,
                        p.id,
                        p.category_id,
                        p.title,
                        p.body,
                        p.author,
                        p.created_at
                    FROM ' . $this->table . ' p
                    LEFT JOIN
                        categories c ON p.category_id = c.id
                    WHERE
                        p.id = ?
                    LIMIT 0,1
                    ';

            //PREPARE STATEMENT
            $stmt = $this->conn->prepare($query);
            //BIND ID TO STMT
            $stmt->bindParam(1, $this->id);
            //EXCUTE STATEMENT
            $stmt->execute();

            //FETCH THE ARRAY THAT WILL BE RETURNED AND ASSIGN PROPERTY
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // SET PROPERTY
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        } 

        //METHOD TO CREATE POST
        public function create(){
            //create query
            $query = 'INSERT INTO '. $this->table .'
                    SET
                        title = :title,
                        body = :body,
                        author = :author,
                        category_id = :category_id
            ';

            //PREPARE STATEMENT
            $stmt = $this->conn->prepare($query);

            //CLEAN UP DATA
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //BIND DATA(bind the named parameter)
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            //EXECUTE QUERY
            if ($stmt->execute()) {
                return true;
            }

            //PRINT ERROR IF SOMETHING GOES WRONG
            printf("ERROR: %s.\n", $stmt->error);

            return false;

        }

        //METHOD TO UPDATE POST
        public function update(){
            //UPDATE QUERY
            $query = 'UPDATE ' . $this->table . '
                    SET 
                        title = :title,
                        body = :body,
                        author = :author,
                        category_id = :category_id
                    WHERE
                        id = :id
            ';

            //PREPARE STATEMENT
            $stmt = $this->conn->prepare($query);

            //CLEAN UP DATA
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));
            
            //BIND DATA
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            //EXECUTE QUERY
            if ($stmt->execute()) {
                return true;
            }

            //PRINT ERROR IF ANYTHING GOES WRONG
            printf("ERROR: %s.\n", $stmt->error);

            return false;
        }

        //METHOD TO DELETE POST
        public function delete(){
            //DELETE QUERY
            $query = 'DELETE FROM '. $this->table . ' WHERE id= :id';

            //PREP STATEMENT
            $stmt = $this->conn->prepare($query);

            //CLEAN DATA
            $this->id = htmlspecialchars(strip_tags($this->id));

            //BIND DATA
            $stmt->bindParam(':id', $this->id);

            //EXECUTE ststement
            if ($stmt->execute()) {
                return true;
            }

            //PRINT ERROR INCASE
            printf("ERROR: %s.\n", $stmt->error);

            return false;
        }

    }
?>