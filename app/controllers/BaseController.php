<?php

namespace App\Controllers;

// Importar la clase Twig
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController {
  // Definimos una instancia de Twig
  protected $twig;

  public function __construct()
  {
    // Crear una instancia del cargador de plantillas de Twig
    $loader = new FilesystemLoader(__DIR__ . '/../views');

    // Crear una instancia del entorno de Twig
    $this->twig = new Environment($loader);
  }
}
