<?php
    class About {
        // DB Stuff
        private $conn;
        private $table = 'tbl_about';
        // Properties
        public $id;
        public $name;
        public $description;
        public $created_at;
        public $status;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get About
        public function read() {
            // Create query
            $query = 'SELECT id,name,description,created_at,status FROM '.$this->table.' ORDER BY id ASC';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Execute query
            $stmt->execute();
            return $stmt;
        }

        // Get Single About
        public function read_single(){
            // Create query
            $query = 'SELECT id,name,description,created_at,status FROM '.$this->table.' WHERE id = ? LIMIT 0,1';
            //Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind ID
            $stmt->bindParam(1, $this->id);
            // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row>0){
                // set properties
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->description = $row['description'];
                $this->created_at = $row['created_at'];
                $this->status = $row['status'];
                return true;
            }
            return false;
        }

        // Get About With Pagination
        public function read_pagination($start,$limit){
            $query = 'SELECT id,name,description,created_at,status FROM '.$this->table.' LIMIT '.$start.','.$limit.'';
            //Prepare statement
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        // Create About
        public function create() {
            // Create Query
            $query = 'INSERT INTO '.$this->table.' SET name = :name, description= :description';
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            // Bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            // Execute query
            if($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);
            return false;
        }

        // Update About
        public function update() {
            // Create Query
            $query = 'UPDATE '.$this->table.' SET name = :name, description = :description, created_at = :created_at, status = :status WHERE id = :id';
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->status = htmlspecialchars(strip_tags($this->status));
            $this->created_at = htmlspecialchars(strip_tags($this->created_at));
            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':created_at', $this->created_at);
            // $stmt->bindParam(1, $this->id);
            // Execute query
            if($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);
            return false;
        }

        // Delete About
        public function delete() {
            // Create query
            // $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            // Bind Data
            $stmt->bindParam(1,$this->id);
            // $stmt-> bindParam(':id', $this->id);
            // Execute query
            if($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);
            return false;
        }

    }
?>
