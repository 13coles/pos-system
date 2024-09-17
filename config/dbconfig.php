<?php
  require_once('config/data_operations.php');

  class dbconfig
  {
    public $connection;
    public function __construct() {
      $this->db_connect();
    }

    public function db_connect() {
      $this->connection = mysqli_connect('localhost', 'root', '', 'inventory_db');
      if (!$this->connection) {
        die("Connect Failed: " . mysqli_connect_error());
      }
    }
    

    public function check($a) {
      $return = mysqli_real_escape_string($this->connection,$a);
      return $return;
    }
  }
?>