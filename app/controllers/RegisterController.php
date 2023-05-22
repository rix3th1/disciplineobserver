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

      // Validamos que los datos sean correctos
      if (empty($_GET['_id'])) {
        throw new Exception("Ingrese la cédula");  
      }

      if (strlen($_GET['_id']) < 8 || strlen($_GET['_id']) > 10) {
        throw new Exception("El valor de la cédula es incorrecto");
      }

      if (empty($_GET['name'])) {
        throw new Exception('Ingrese los nombres');
      }

      if (empty($_GET['lastname'])) {
        throw new Exception('Ingrese los apellidos');
      }

      if (empty($_GET['telephone'])) {
        throw new Exception('Ingrese el teléfono');
      }

      if (strlen($_GET['telephone']) !== 10) {
        throw new Exception("El número de telefono debe tener 10 dígitos");
      }

      if (empty($_POST['email'])) {
        throw new Exception('Ingrese el correo');
      }

      if (empty($_POST['password'])) {
        throw new Exception('Ingrese la contraseña');
      }

      if (empty($_POST['identification'])) {
        throw new Exception('Seleccione la identificación');
      }

      // Creamos una instancia de UserModel
      $userModelInstance = new UserModel();
      $userFound = $userModelInstance->findById($_GET['_id']);
      $emailExists = $userModelInstance->findByEmail($_POST['email']);
      
      if ($userFound || $emailExists) {
        throw new Exception("El usuario o el correo ya existen");
      }

      // Creamos el usuario
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
}
