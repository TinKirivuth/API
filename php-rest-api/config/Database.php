<?php
  date_default_timezone_set('Asia/Phnom_Penh');
  class Database {
      // DB Params
      // private $host = 'localhost';
      // private $db_name = 'restfull_api';
      // private $username = 'root';
      // private $password = '';
      // private $conn;

      private $host = 'localhost';
      private $db_name = 'kc_restful_api';//restfull_api
      private $username = 'root';
      private $password = '123abc+-*/';//123abc+-*/
      private $conn;

      // DB Connect
      public function connect() {
          $this->conn = null;
          try {
              $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
              echo 'Connection Error: '.$e->getMessage();
          }
          return $this->conn;
      }
  }
