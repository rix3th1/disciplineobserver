<?php

namespace App\Controllers;

use Exception;
use App\Models\SessionModel;

class AuthController extends BaseController {
  public function showLoginPage()
  {
    echo $this->twig->render('login.twig', [
      'title' => 'Accede'
    ]);
  }

  public function authenticate()
  {
    try {
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      if (empty($_POST['post'])) {
        throw new Exception('Ingrese el cargo');
      }

      if (empty($_POST['email'])) {
        throw new Exception('Ingrese el correo');
      }
  
      if (empty($_POST['password'])) {
        throw new Exception('Ingrese la contraseña');
      }

      $sessionModelInstance = new SessionModel();
      $auth = $sessionModelInstance->auth(
        $_POST['email'],
        $_POST['password']
      );

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
    $sessionModelInstance = new SessionModel();
    $sessionModelInstance->logOut();
    header('Location: /');
  }
}
