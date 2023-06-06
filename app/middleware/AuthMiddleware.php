<?php

namespace App\Middleware;

use Exception;
// Importamos el modelo de la sesión
use App\Models\SessionModel;

class AuthMiddleware {
  protected SessionModel $sessionModelInstance;
  
  // Constructor que inicia la sesión
  public function __construct()
  {
    $this->sessionModelInstance = new SessionModel;
    $this->sessionModelInstance->sessionStart();
  }

  public function handle(): void
  {
    // Verifica si el usuario está autenticado
    if (!isset($_SESSION['user_discipline_observer']) || empty($_SESSION['user_discipline_observer'])) {
      // Si no está autenticado, lo redirigimos al login
      header('Location: /');
      exit;
    }

    // Si está autenticado, continuamos
  }

  public function handlePermissionsAdmin(): void
  {
    if ($_GET['auth'] === 'false') {
      return;
    }

    // Verificamos que el usuario este logueado
    if ($_GET['auth'] ?? 'true' === 'true') {
      // Verificamos que el usuario este logueado
      $this->handle();

      // Verificamos que el usuario sea un administrador y su rol sea el apropiado
      if ($_SESSION['user_discipline_observer']['role'] !== 'Secretaria' && $_SESSION['user_discipline_observer']['role'] !== 'Rector') {
        throw new Exception("No estás autorizado para realizar esta acción");
      }

      if (!in_array('admin_students', $_SESSION['user_discipline_observer']['permissions']) && !in_array('admin_teachers', $_SESSION['user_discipline_observer']['permissions'])) {
        throw new Exception("No tienes permisos para realizar esta acción");
      }
    }
  }
}
