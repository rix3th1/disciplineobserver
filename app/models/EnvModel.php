<?php

namespace App\Models;

// Importamos Exception
use Exception;

class EnvModel {
  public function reader($key)
  {
    // Verificamos si existe la variable de entorno
    if (defined('_ENV_CACHE')) {
      // Si existe la variable de entorno, la obtenemos de la constante
      $vars = _ENV_CACHE;
    } else {
      //  Si no existe la variable de entorno, la obtenemos del archivo .env
      $file = 'app/env/.env';
      
      // Verificamos si el archivo existe
      if (!file_exists($file)) {
        throw new Exception("The environment file ($file) does not exists. Please create it");
      }

      //  Obtenemos las variables de entorno
      $vars = parse_ini_file($file);
      //  Creamos una constante con las variables de entorno
      define('_ENV_CACHE', $vars);
    }

    //  Verificamos si existe la variable de entorno especificada
    if (isset($vars[$key])) {
      //  Si existe la variable de entorno, la retornamos
      return $vars[$key];
    } else {
      //  Si no existe la variable de entorno, lanzamos una excepción
      throw new Exception("The specified key ($key) does not exist in the environment file");
    }
  }
}
