<?php

namespace App\Controllers;

// importar la clase que creamos para el middleware de verificacion de sesion
use App\Middleware\AuthMiddleware;

class HomeController extends BaseController {
  public function showHomePage()
  {
    // verificar que el usuario este logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    
    // renderizar la vista home, donde se da la bienvenida
    echo $this->twig->render('home.twig', [
      'title' => 'Inicio',
      'userLogged' => $_SESSION['user_discipline_observer']
    ]);
  }
}
