<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Models\UserModel;

class RegisterController extends BaseController {
  public function askData()
  {
    // Mostramos la vista de tomar los datos personales
    echo $this->twig->render('askdata-register.twig', [
      'title' => 'Datos personales'
    ]);
  }

  public function requestData()
  {
    // Mostramos la vista del formulario de crear la cuenta
    echo $this->twig->render('requestdata-register.twig', [
      'title' => 'Crear una cuenta'
    ]);
  }

  public function register()
  {
    try {
      // Validamos que se haya enviado los datos
      if (!$_GET || !$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      // Validamos los datos
      $this->validateData(
        $_GET['_id'],
        $_GET['name'],
        $_GET['lastname'],
        $_GET['telephone'],
        $_POST['email'],
        $_POST['password'],
        $_POST['identification']
      );

      // Creamos el usuario
      $userModelInstance = new UserModel();
      $userModelInstance->create(
        $_GET['_id'],
        $_GET['name'],
        $_GET['lastname'],
        $_GET['telephone'],
        $_POST['email'],
        $_POST['password'],
        $_POST['identification']
      );

      // Mostramos el mensaje de registro exitoso
      echo $this->twig->render('requestdata-register.twig', [
        'title' => 'Registro exitoso',
        'success' => 'Registrado exitosamente, por favor inicie sesión'
      ]);

    } catch (Exception $e) {
      $error = $e->getMessage();
      echo $this->twig->render('requestdata-register.twig', [
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
    // Validamos que los datos sean correctos
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
