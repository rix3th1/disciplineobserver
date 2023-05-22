<?php

namespace App\Controllers;

use Exception;
use App\Middleware\AuthMiddleware;
use App\Models\{ EmailSenderModel, UserModel, SessionModel };

class UserController extends BaseController {
  public function showRequestEmailPage()
  {
    echo $this->twig->render('request-email.twig', [
      'title' => '¿Has olvidado la contraseña?'
    ]);
  }

  public function showRequestCodePage()
  {
    try {
      // Generar un código de verificación único
      $min = 100000; // Valor mínimo del código numérico
      $max = 999999; // Valor máximo del código numérico
      $verificationCode = random_int($min, $max); // Generar un número entero aleatorio dentro del rango

      $emailSenderModelInstance = new EmailSenderModel();
      $codeSended = $emailSenderModelInstance->sendEmail(
        'Código de verificación para restablecer contraseña',
        $_GET['email'],
        "Su código de verificación es: " . $verificationCode
      );

      if (!$codeSended) {
        throw new Exception("Error durante el envio del codigo de verificación");
      }

      $sessionModelInstance = new SessionModel();
      $sessionModelInstance->sessionStart();
      $_SESSION['verification_pending'] = [
        "email" => $_GET['email'],
        "code" => $verificationCode
      ];

      echo $this->twig->render('request-code.twig', [
        'title' => '¿Has olvidado la contraseña?',
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

  public function showPasswordPage()
  {
    echo $this->twig->render('change-password.twig', [
      'title' => '¿Has olvidado la contraseña?'
    ]);
  }

  public function updatingPassword()
  {
    try {
      $sessionModelInstance = new SessionModel();
      $sessionModelInstance->sessionStart();
      
      if ($_POST['password'] !== $_POST['password_confirm']) {
        throw  new Exception("Las contraseñas no coinciden");
      }

      $userModelInstance = new UserModel();
      $passwordChanged = $userModelInstance->updatePassword($_SESSION['verification_pending']['email'], $_POST['password']);

      if ($passwordChanged) {
        echo $this->twig->render('success-password.twig', [
          'title' => '¿Has olvidado la contraseña?'
        ]);
      }

    } catch (Exception $e) {
      $error = $e->getMessage();

      echo $this->twig->render('change-password.twig', [
        'title' => 'Error',
        'error' => $error
      ]);
    }
  }

  public function verifyVerificationCode()
  {
    try {
      $sessionModelInstance = new SessionModel();
      $sessionModelInstance->sessionStart();

      if ((int) $_SESSION['verification_pending']['code'] !== (int) $_POST['verification_code']) {
        throw new Exception("El codigo de verificación es incorrecto");
      }

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

  public function changePassword()
  {
    if (empty($_GET['email'])) {
      return $this->showRequestEmailPage();
    }

    $this->showRequestCodePage();
  }
}