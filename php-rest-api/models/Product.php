<?php
  class Product {
    // DB stuff
    private $conn;
    private $table = 'tbl_products';

    // Post Properties
    public $id;
    public $name;
    public $title;
    public $description;
    public $icon;
    public $category_id;
    public $created_at;
    public $is_public;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Posts
    public function read() {
        // Create query
        $query = 'SELECT c.name as category_name, p.id, p.name, p.title, p.description, p.icon, p.category_id, p.created_at, p.is_public
                  FROM ' . $this->table . ' p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Get Single Post
    public function read_single($id) {
        // // Method1
          // $query = 'SELECT c.name as category_name, p.id, p.name, p.title, p.description, p.icon, p.category_id, p.created_at, p.is_public
          //           FROM ' . $this->table . ' p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1';
          // // Prepare statement
          // $stmt = $this->conn->prepare($query);
          // // Bind ID
          // $stmt->bindParam(1, $this->id);
          // // Execute query
          // $stmt->execute();
          // $row = $stmt->fetch(PDO::FETCH_ASSOC);
          // // Set properties
          // $this->category_name = $row['category_name'];
          // $this->name = $row['name'];
          // $this->title = $row['title'];
          // $this->description = $row['description'];
          // $this->icon = $row['icon'];
          // $this->category_id = $row['category_id'];
          // $this->created_at = $row['created_at'];
          // $this->is_public = $row['is_public'];

        // Method 2
        $query = 'SELECT c.name as category_name, p.id, p.name, p.title, p.description, p.icon, p.category_id, p.created_at, p.is_public
                  FROM ' . $this->table . ' p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = '.$id.' LIMIT 0,1';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Post With Pagination
    public function read_pagination($start,$limit){
        // $query = 'SELECT id,name FROM '.$this->table.' LIMIT '.$start.','.$limit.'';
        $query = 'SELECT c.name as category_name, p.id, p.name, p.title, p.description, p.icon, p.category_id, p.created_at, p.is_public
                  FROM ' . $this->table . ' p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT '.$start.','.$limit.'';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Post By Category
    public function read_by_category($category_id){
        $query = 'SELECT c.name as category_name, p.id, p.name, p.title, p.description, p.icon, p.category_id, p.created_at, p.is_public
                  FROM ' . $this->table . ' p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id='.$category_id.' ORDER BY p.created_at DESC';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Post By Category with Pagination
    public function read_by_category_pagination($category_id,$start,$limit){
        $query = 'SELECT c.name as category_name, p.id, p.name, p.title, p.description, p.icon, p.category_id, p.created_at, p.is_public
                  FROM ' . $this->table . ' p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id='.$category_id.' ORDER BY p.created_at DESC LIMIT '.$start.','.$limit.'';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create Post
    public function create() {
        // Create query
        $query = 'INSERT INTO ' .$this->table. ' SET name = :name, title = :title, description = :description, icon = :icon, category_id = :category_id, is_public = :is_public';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->icon = htmlspecialchars(strip_tags($this->icon));
        $this->category_id = $this->category_id;
        $this->is_public = $this->is_public;
        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':icon', $this->icon);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':is_public', $this->is_public);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Update Post
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . ' SET name = :name, title = :title, description = :description, icon = :icon, category_id = :category_id, is_public = :is_public WHERE id = :id';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->icon = htmlspecialchars(strip_tags($this->icon));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->is_public = htmlspecialchars(strip_tags($this->is_public));
        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':icon', $this->icon);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':is_public', $this->is_public);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Delete Post
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        // Bind data
        $stmt->bindParam(':id', $this->id);
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

  }
 