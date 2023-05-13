<?php

namespace App\Controllers;

use Exception;
use App\Models\SessionModel;

class AuthController extends BaseController {
  public function showRequestPerson() {
    echo $this->twig->render('requestdata-login.twig', [
      'title' => 'Seleccione su cargo'
    ]);
  }

  public function showLoginPage()
  {
    try {
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
      }

      if (isset($_POST['parent'])) {
        echo $this->twig->render('login.twig', [
          'title' => 'Accede Padre de Familia',
          'post' => 'parent'
        ]);
        return;
      }

      if (isset($_POST['teacher'])) {
        echo $this->twig->render('login.twig', [
          'title' => 'Accede Docente',
          'post' => 'teacher'
        ]);
        return;
      }

      if (isset($_POST['rector'])) {
        echo $this->twig->render('login.twig', [
          'title' => 'Accede Rector',
          'post' => 'rector'
        ]);
      }
      
    } catch (Exception $e) {
      $error = $e->getMessage();
      echo $this->twig->render('requestdata-login.twig', [
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function authenticate()
  {
    try {
      if (!$_POST) {
        http_response_code(400);
        throw new Exception('petición incorrecta');
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
