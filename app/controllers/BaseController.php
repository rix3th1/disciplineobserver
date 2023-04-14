<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController {
  protected $twig;

  public function __construct()
  {
    // Crear una instancia del cargador de plantillas de Twig
    $loader = new FilesystemLoader(__DIR__ . '/../views');

    // Crear una instancia del entorno de Twig
    $this->twig = new Environment($loader);
  }
}
