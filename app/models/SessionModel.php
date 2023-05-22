<?php

namespace App\Models;

use Exception;

class SessionModel extends BaseModel {
  public function auth(
    $email,
    $password
  )
  {
    $userModelInstance = new UserModel();
    $dataUser = $userModelInstance->findByEmail($email);
    $securityModelInstance = new SecurityModel();

    if ($dataUser) {
      if ($dataUser->role_id !== $_POST['post']) {
        throw new Exception("El cargo que seleccionó es incorrecto"); 
      }
    }

    if ($dataUser && $securityModelInstance->verifyPassword($password, $dataUser->password)) {
      $permissions = explode(',', $dataUser->permissions);
      $this->sessionStart();
      return $_SESSION['user_discipline_observer'] = [
        'name' => $dataUser->name,
        'lastname' => $dataUser->lastname,
        'telephone' => $dataUser->telephone,
        'email' => $dataUser->email,
        'role' => $dataUser->role,
        'permissions' => $permissions
      ];
    }

    throw new Exception("El correo o la contraseña son incorrectas");    
  }

  public function sessionStart()
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  public function logOut()
  {
    $this->sessionStart();
    session_destroy();
  }
}
