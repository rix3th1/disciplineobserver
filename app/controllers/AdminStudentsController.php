<?php

namespace App\Controllers;

use Exception;
use App\Middleware\AuthMiddleware;

class AdminStudentsController extends BaseController {
  public function showDashboardStudents()
  {
    // verificar que el usuario este logueado
    $authMiddlewareInstance = new AuthMiddleware();
    $authMiddlewareInstance->handle();
    
    // renderizar la vista home, donde se da la bienvenida
    echo $this->twig->render('dashboard-students.twig', [
      'title' => 'Profesores',
      'userLogged' => $_SESSION['user_discipline_observer']
    ]);
  }
}