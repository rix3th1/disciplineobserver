<?php

namespace App\Models;

use PDO;

class BaseModel {
  protected $db;

  public function __construct() {
    $this->db = $this->getDatabase();
  }

  public function getDatabase()
  {
    $env = new EnvModel();
    $password = $env->reader('MYSQL_PSW');
    $username = $env->reader('MYSQL_USER');
    $dbname = $env->reader('MYSQL_DB');
    $host = $env->reader('MYSQL_HOST');
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->query('set names utf8;');
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $conn;
  }
}
