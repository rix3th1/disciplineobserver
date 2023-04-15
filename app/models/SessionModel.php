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
    $dataUser = $userModelInstance->getByEmail($email);
    $securityModelInstance = new SecurityModel();

    if ($dataUser && $securityModelInstance->verifyPassword($password, $dataUser->password)) {
      $permissions = explode(',', $dataUser->permissions);
      return [
        'name' => $dataUser->name,
        'permissions' => $permissions
      ];
    }

    throw new Exception("El correo o la contraseña son incorrectas");    
  }
}