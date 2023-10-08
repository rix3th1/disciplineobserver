<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Models\SessionModel;

class AuthController extends BaseController {
  protected SessionModel $sessionModelInstance;

  public function __construct()
  {
    // Llamar al constructor del padre
    parent::__construct();

    // Instanciar modelo de sesión
    $this->sessionModelInstance = new SessionModel;
  }

  public function showLoginPage(): void
  {
    // Obtenemos todos los roles
    $roles = $this->sessionModelInstance->getAllRoles();

    // Mostramos la página de inicio, el login
    echo $this->twig->render('login.twig', [
      'title' => 'Accede',
      'roles' => $roles
    ]);
  }

  public function authenticate(): void
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

      // Patrón de expresión regular para validar el formato del email
      $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

      // Validar el email utilizando la función preg_match()
      if (!preg_match($pattern, $_POST['email'])) {
        throw new Exception("El formato del correo es incorrecto");
      }

      // Autenticamos al usuario
      $auth = $this->sessionModelInstance->auth(
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
      $roles = $this->sessionModelInstance->getAllRoles();
    
      echo $this->twig->render('login.twig', [
        'title' => 'Error',
        'error' => $error,
        'roles' => $roles
      ]);
    }
  }

  public function logOut(): void
  {
    // Cerramos la sesión
    $this->sessionModelInstance->logOut();
    
    // Redirigimos al inicio
    header('Location: /');
  }
}
