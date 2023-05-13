<?php

namespace App\Middleware;

use App\Models\SessionModel;

class AuthMiddleware {
  public function __construct()
  {
    $sessionModelInstance = new SessionModel();
    $sessionModelInstance->sessionStart();
  }

  public function handle()
  {
    // Verifica si el usuario está autenticado
    if (!isset($_SESSION['user_discipline_observer']) || empty($_SESSION['user_discipline_observer'])) {
      header('Location: /');
      exit;
    }

    // Si está autenticado, continuamos
  }
}
