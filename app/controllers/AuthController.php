<?php

namespace App\Controllers;

use Exception;
use App\Models\SessionModel;

class AuthController extends BaseController {
  public function showLoginPage()
  {
    echo $this->twig->render('login.twig', [
      'title' => 'Iniciar sesión'
    ]);
  }

  public function authenticate()
  {
    try {
      $data = $_POST;

      if (!$data) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      $identification = $data['identification'];
      $email = $data['email'];
      $password = $data['password'];

      $this->validateAuthData(
        $identification,
        $email,
        $password
      );

      $sessionModelInstance = new SessionModel();
      $auth = $sessionModelInstance->auth(
        $email,
        $password
      );

      if ($auth) {
        echo $this->twig->render('home.twig', [
          'title' => 'Bienvenido al observador'
        ]);
      }

    } catch (Exception $e) {
      $error = $e->getMessage();
      echo $this->twig->render('login.twig', [
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function validateAuthData($identification, $email, $password) {
    if (empty($identification)) {
      throw new Exception('Seleccione la identificación');
    }

    if (empty($email)) {
      throw new Exception('Ingrese el correo');
    }

    if (empty($password)) {
      throw new Exception('Ingrese la contraseña');
    }
  }
}