<?php

namespace App\Controllers;

// importar la clase que creamos para el middleware de verificacion de sesion
use App\Middlewares\AuthMiddleware;

class HomeController extends BaseController {
  protected AuthMiddleware $authMiddlewareInstance;

  public function __construct()
  {
    // Llamar al constructor del padre
    parent::__construct();

    // Instanciar la clase AuthMiddleware
    $this->authMiddlewareInstance = new AuthMiddleware;

    // Verificar que el usuario este logueado
    $this->authMiddlewareInstance->handle();
  }

  public function showHomePage(): void
  {
    // renderizar la vista home, donde se da la bienvenida
    echo $this->twig->render('home.twig', [
      'title' => 'Inicio',
      'userLogged' => $_SESSION['user_discipline_observer']
    ]);
  }
}
