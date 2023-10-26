<?php

namespace App\Controllers;

// importar la clase que creamos para el middleware de verificacion de sesion
use App\Middlewares\AuthMiddleware;

class HelpController extends BaseController {
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

  public function showHelpPage(): void
  {
    // renderizar la vista de ayuda, donde se da la bienvenida
    echo $this->twig->render('help.twig', [
      'title' => 'Ayuda',
      'userLogged' => $_SESSION['user_discipline_observer']
    ]);
  }
}
