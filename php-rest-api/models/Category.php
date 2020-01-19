<?php
  class Category {
    // DB Stuff
    private $conn;
    private $table = 'categories';
    // Properties
    public $id;
    public $name;
    public $description;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Category
    public function read() {
        // Create query
        $query = 'SELECT id,name,description,created_at FROM '.$this->table.' ORDER BY id DESC';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Get Single Category
    public function read_single(){
        // Create query
        $query = 'SELECT id,name,description,created_at FROM '.$this->table.' WHERE id = ? LIMIT 0,1';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind ID
        $stmt->bindParam(1, $this->id);
        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // set properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->created_at = $row['created_at'];
    }

    // Get Category With Pagination
    public function read_pagination($start,$limit){
        $query = 'SELECT id,name,description,created_at FROM '.$this->table.' ORDER BY id DESC LIMIT '.$start.','.$limit.'';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create Category
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

    // Update Category
    public function update() {
        // Create Query
        $query = 'UPDATE '.$this->table.' SET name = :name, description = :description WHERE id = :id';
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        // $stmt->bindParam(1, $this->id);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);
        return false;
    }

    // Delete Category
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
