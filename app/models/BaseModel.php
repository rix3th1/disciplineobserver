<?php

namespace App\Models;

// Importamos la librería de conexión a la base de datos
use PDO;

class BaseModel {
  // Definimos una variable que guarda la conexión a la base de datos
  protected PDO $db;
  protected EnvModel $env;

  // Creamos el constructor de la clase que conecta a la base de datos
  public function __construct() {
    // Creamos una instancia de la clase EnvModel
    $this->env = new EnvModel();

    // Guardamos la conexión a la base de datos en la variable $db
    $this->db = $this->getDatabase();
  }

  public function getDatabase(): PDO
  {
    // Leemos las variables de entorno
    $password = $this->env->reader('MYSQL_PSW');
    $username = $this->env->reader('MYSQL_USER');
    $dbname = $this->env->reader('MYSQL_DB');
    $host = $this->env->reader('MYSQL_HOST');
    $port = $this->env->reader('MYSQL_PORT');

    // Creamos la conexión
    $conn = new PDO("mysql:host=$host:$port;dbname=$dbname", $username, $password);
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
