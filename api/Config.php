<?php

class Config {
	  // Database Details
	  private const DBHOST = 'localhost';
	  private const DBUSER = 'root';
	  private const DBPASS = '1234';
	  private const DBNAME = 'stagetier';
	  // Data Source Network
	  private $dsn = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME . '';
	  // conn variable
	  protected $conn = null;

	  // Constructor Function
	  public function __construct() {
	    try {
	      $this->conn = new PDO($this->dsn, self::DBUSER, self::DBPASS);
	      $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	    } catch (PDOException $e) {
	      die('Connectionn Failed : ' . $e->getMessage());
	    }
	    return $this->conn;
	  }

	  protected function sendJSON($infos){
		header("Content-Type: application/json");
		header("Access-Control-Allow-Origin: *");
		echo json_encode($infos, JSON_UNESCAPED_UNICODE);
	}

}