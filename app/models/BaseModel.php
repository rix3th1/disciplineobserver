<?php

namespace App\Models;

// Importamos la librería de conexión a la base de datos
use PDO;

class BaseModel {
  // Definimos una variable que guarda la conexión a la base de datos
  protected $db;

  // Creamos el constructor de la clase que conecta a la base de datos
  public function __construct() {
    $this->db = $this->getDatabase();
  }

  public function getDatabase()
  {
    // Creamos una instancia de la clase EnvModel
    $env = new EnvModel();

    // Leemos las variables de entorno
    $password = $env->reader('MYSQL_PSW');
    $username = $env->reader('MYSQL_USER');
    $dbname = $env->reader('MYSQL_DB');
    $host = $env->reader('MYSQL_HOST');

    // Creamos la conexión
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    //  Configuramos el charset
    $conn->query('set names utf8;');
    // Configuraciones adicionales
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    // Retornamos la conexión
    return $conn;
  }
}
