<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;

class HomeController extends BaseController {
  public function showHomePage()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];
    
    echo $this->twig->render('home.twig', [
      'title' => 'Inicio',
      'roleInfo' => $userLogged['role'],
      'permissions' => $userLogged['permissions']
    ]);
  }
}
