<?php

namespace App\Controllers;

use Exception;
use App\Models\UserModel;

class RegisterController extends BaseController {
  public function askData()
  {
    echo $this->twig->render('askdata.twig', [
      'title' => 'Datos personales'
    ]);
  }

  public function requestData()
  {
    echo $this->twig->render('requestdata.twig', [
      'title' => 'Crear una cuenta'
    ]);
  }

  public function register()
  {
    try {
      $get = $_GET;
      $post = $_POST;

      if (!$get || !$post) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      $_id = $get['_id'];
      $name = $get['name'];
      $lastname = $get['lastname'];
      $telephone = $get['telephone'];
      $email = $post['email'];
      $password = $post['password'];
      $role = $post['identification'];

      $this->validateData(
        $_id,
        $name,
        $lastname,
        $telephone,
        $email,
        $password,
        $role
      );

      $userModelInstance = new UserModel();
      $userModelInstance->create(
        $_id,
        $name,
        $lastname,
        $telephone,
        $email,
        $password,
        $role
      );

      echo $this->twig->render('login.twig', [
        'title' => 'Registro exitoso',
        'success' => 'Usted se ha registrado exitosamente, por favor inicia sesión'
      ]);

    } catch (Exception $e) {
      $error = $e->getMessage();
      echo $this->twig->render('requestdata.twig', [
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function validateData(
    $_id,
    $name,
    $lastname,
    $telephone,
    $email,
    $password,
    $role
  )
  {
    if (empty($_id)) {
      throw new Exception("Ingrese la cédula");  
    }

    if (empty($name)) {
      throw new Exception('Ingrese los nombres');
    }

    if (empty($lastname)) {
      throw new Exception('Ingrese los apellidos');
    }

    if (empty($telephone)) {
      throw new Exception('Ingrese el teléfono');
    }

    if (empty($email)) {
      throw new Exception('Ingrese el correo');
    }

    if (empty($password)) {
      throw new Exception('Ingrese la contraseña');
    }

    if (empty($role)) {
      throw new Exception('Seleccione la identificación');
    }
  }
}