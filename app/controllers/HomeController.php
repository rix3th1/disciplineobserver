<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;

class HomeController extends BaseController {
  public function showHomePage()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    
    echo $this->twig->render('home.twig', [
      'title' => 'Inicio',
      'userLogged' => $_SESSION['user_discipline_observer']
    ]);
  }
}
