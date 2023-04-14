<?php

namespace App\Controllers;

use Exception;

class AuthController extends BaseController {
  public function showLoginPage()
  {
    echo $this->twig->render('login.twig', [
      'title' => 'Iniciar sesión'
    ]);
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

      $this->validateAuthData($identification, $email, $password);



    } catch (Exception $e) {
      $error = $e->getMessage();
      echo $this->twig->render('login.twig', [
        'error' => $error
      ]);
    }
  }
}