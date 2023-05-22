<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Models\SessionModel;

class AuthController extends BaseController {
  public function showLoginPage()
  {
    // Mostramos la página de inicio, el login
    echo $this->twig->render('login.twig', [
      'title' => 'Accede'
    ]);
  }

  public function authenticate()
  {
    try {
      // Validamos que el usuario haya enviado los datos
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      // Validamos que los datos sean correctos
      if (empty($_POST['post'])) {
        throw new Exception('Ingrese el cargo');
      }

      if (empty($_POST['email'])) {
        throw new Exception('Ingrese el correo');
      }
  
      if (empty($_POST['password'])) {
        throw new Exception('Ingrese la contraseña');
      }

      // Autenticamos al usuario
      $sessionModelInstance = new SessionModel();
      $auth = $sessionModelInstance->auth(
        $_POST['email'],
        $_POST['password']
      );

      // Si el usuario se autenticá, redirigimos al inicio
      if ($auth) {
        header('Location: /inicio');
        exit;
      }

    } catch (Exception $e) {
      $error = $e->getMessage();
      echo $this->twig->render('login.twig', [
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function logOut()
  {
    // Cerramos la sesión
    $sessionModelInstance = new SessionModel();
    $sessionModelInstance->logOut();
    // Redirigimos al inicio
    header('Location: /');
  }
}
