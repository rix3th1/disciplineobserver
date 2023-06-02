<?php

namespace App\Controllers;

use Exception;
use App\Middleware\AuthMiddleware;

class AdminTeachersController extends BaseController {
  public function showDashboardTeachers()
  {
    // verificar que el usuario este logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    
    // renderizar la vista home, donde se da la bienvenida
    echo $this->twig->render('dashboard-teachers.twig', [
      'title' => 'Profesores',
      'userLogged' => $_SESSION['user_discipline_observer']
    ]);
  }
}