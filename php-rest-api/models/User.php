<?php
  class User {
    // DB Stuff
    private $conn;
    private $table = 'tbl_user';
    // Properties
    public $id;
    public $name;
    public $password;
    public $type;
    public $status;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get User
    public function read() {
        // Create query
        $query = 'SELECT id,name,password,type,status FROM '.$this->table.' ORDER BY id DESC';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Get Single User
    public function read_single(){
        // Create query
        $query = 'SELECT id,name,password,type,status FROM '.$this->table.' WHERE id = ? LIMIT 0,1';
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
        $this->password = $row['password'];
        $this->type = $row['type'];
        $this->status = $row['status'];
    }

    // Get User With Pagination
    public function read_pagination($start,$limit){
        $query = 'SELECT id,name,password,type,status FROM '.$this->table.' LIMIT '.$start.','.$limit.'';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create User
    public function create() {
        // Create Query
        $query = 'INSERT INTO '.$this->table.' SET name = :name, password= :password, type= :type, status= :status';
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->status = htmlspecialchars(strip_tags($this->status));
        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':status', $this->status);
        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $password_hash);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);
        return false;
    }

    // Update User
    public function update() {
        // Create Query
        $query = 'UPDATE '.$this->table.' SET name = :name, type = :type, status = :status WHERE id = :id';
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->status = htmlspecialchars(strip_tags($this->status));
        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':status', $this->status);
        // // hash the password before saving to database
        // $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        // $stmt->bindParam(':password', $password_hash);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);
        return false;
    }

    // Delete User
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

    // Get Single User or Login
    public function login(){
        // Create query
        $query = 'SELECT id,name,password,type,status FROM '.$this->table.' WHERE name = ?';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind ID
        $stmt->bindParam(1, $this->name);
        // Execute query
        if($stmt->execute()) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($this->password, $row['password'])) {
                    // set properties
                    $this->id = $row['id'];
                    $this->name = $row['name'];
                    $this->password = $row['password'];
                    $this->type = $row['type'];
                    $this->status = $row['status'];
                    return true;
                }
            }
        }
        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);
        return false;
    }

  }
  ?>
