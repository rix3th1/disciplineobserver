<?php

namespace App\Middleware;

// Importamos el modelo de la sesión
use App\Models\SessionModel;

class AuthMiddleware {
  // Constructor que inicia la sesión
  public function __construct()
  {
    $sessionModelInstance = new SessionModel();
    $sessionModelInstance->sessionStart();
  }

  public function handle()
  {
    // Verifica si el usuario está autenticado
    if (!isset($_SESSION['user_discipline_observer']) || empty($_SESSION['user_discipline_observer'])) {
      // Si no está autenticado, lo redirigimos al login
      header('Location: /');
      exit;
    }

    // Si está autenticado, continuamos
  }
}
