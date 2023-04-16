<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;

class HomeController extends BaseController {
  public function showHomePage()
  {
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    $userLogged = $_SESSION['user_discipline_observer'];
    $roleInfo = '';

    if ($userLogged['role'] === 'parent') {
      $roleInfo = 'Padre de familia';
    }

    if ($userLogged['name'] === 'teacher') {
      $roleInfo = 'Docente';
    }

    echo $this->twig->render('home.twig', [
      'title' => 'Inicio',
      'roleInfo' => $roleInfo,
      'permissions' => $userLogged['permissions']
    ]);
  }
}