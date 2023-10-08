<?php

namespace App\Controllers;

// Importar modelos
use Exception;
use App\Models\{
  EmailSenderModel,
  UserModel,
  SessionModel
};

class UserController extends BaseController {
  protected EmailSenderModel $emailSenderModelInstance;
  protected UserModel $userModelInstance;
  protected SessionModel $sessionModelInstance;

  public function __construct()
  {
    // Llamar al constructor de la clase padre
    parent::__construct();

    // Inicializar los modelos
    $this->emailSenderModelInstance = new EmailSenderModel;
    $this->userModelInstance = new UserModel;
    $this->sessionModelInstance = new SessionModel;
  }

  public function showRequestEmailPage(): void
  {
    // Mostrar la página de solicitud de email
    echo $this->twig->render('request-email.twig', [
      'title' => 'Reestablecer la contraseña'
    ]);
  }

  public function showRequestCodePage(): void
  {
    try {
      // Verificar que el email ingresado exista en la base de datos del observador
      $emailExists = $this->userModelInstance->findByEmail($_GET['email']);

      // Si el email no existe en la base de datos del observador
      if (!$emailExists) {
        throw new Exception("El email ingresado no se encuentra registrado en la base de datos del observador");
      }

      $this->sessionModelInstance->sessionStart();

      // Verificar que el email ingresado no haya sido enviado previamente
      if ($_SESSION['verification_pending']['email'] ?? NULL !== $_GET['email']) {

        // Generar un código de verificación único
        $min = 100000;
        $max = 999999;

        // Generar un número entero aleatorio dentro del rango
        $verificationCode = random_int($min, $max);

        // Enviar el código de verificación por email
        $codeSended = $this->emailSenderModelInstance->sendEmail(
          'Código de verificación para restablecer contraseña',
          $_GET['email'],
          "Su código de verificación es: " . $verificationCode
        );

        // Si hubo un error durante el envio del codigo de verificación
        if (!$codeSended) {
          throw new Exception("Error durante el envio del codigo de verificación");
        }

        // Guardar el cádigo de verificación en la sesión
        $_SESSION['verification_pending'] = [
          "email" => $_GET['email'],
          "code" => $verificationCode
        ];
      }

      // Mostrar la página de verificación del código
      echo $this->twig->render('request-code.twig', [
        'title' => 'Reestablecer la contraseña',
        'email' => $_SESSION['verification_pending']['email'] ?? ''
      ]);
    } catch (Exception $e) {
      $error = $e->getMessage();

      echo $this->twig->render('request-email.twig', [
        'title' => 'Error',
        'error' => $error,
      ]);
    }
  }

  public function showPasswordPage(): void
  {
    // Mostrar la página de cambio de contraseña
    echo $this->twig->render('change-password.twig', [
      'title' => 'Reestablecer la contraseña'
    ]);
  }

  public function updatingPassword(): void
  {
    try {
      $this->sessionModelInstance->sessionStart();
      
      // Verificar que la contraseña coincida con la confirmación de contraseña
      if ($_POST['password'] !== $_POST['password_confirm']) {
        throw  new Exception("Las contraseñas no coinciden");
      }

      // Actualizar la contraseña en la base de datos
      $passwordChanged = $this->userModelInstance->updatePassword($_SESSION['verification_pending']['email'] ?? NULL, $_POST['password']);

      // Si la contraseña fue actualizada mostramos la página de exito
      if ($passwordChanged) {
        echo $this->twig->render('success-password.twig', [
          'title' => 'Reestablecer la contraseña'
        ]);
        
        // Limpiar la sesión  de verificación pendiente
        $_SESSION['verification_pending'] = [];
      }

    } catch (Exception $e) {
      $error = $e->getMessage();

      echo $this->twig->render('change-password.twig', [
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function verifyVerificationCode(): void
  {
    try {
      $this->sessionModelInstance->sessionStart();

      // Verificar que el cádigo de verificación sea correcto
      if ((int) $_SESSION['verification_pending']['code'] !== (int) $_POST['verification_code']) {
        throw new Exception("El codigo de verificación es incorrecto");
      }

      // Como fué correcto, mostrar la página de cambio de contraseña
      $this->showPasswordPage();
    } catch (Exception $e) {
      $error = $e->getMessage();

      echo $this->twig->render('request-code.twig', [
        'title' => 'Error',
        'error' => $error,
        'email' => $_SESSION['verification_pending']['email']
      ]);
    }
  }

  public function changePassword(): void
  {
    // Si no existe el email en la petición, mostramos la pagina de pedir el email
    if (empty($_GET['email'])) {
      $this->showRequestEmailPage();
      return;
    }

    // Si existe el email en la petición, mostramos la pagina de pedir el codigo de verificación
    $this->showRequestCodePage();
  }
}