<?php

namespace App\Models;

class SecurityModel {
  public function preparePlainPassword($password)
  {
    // Retornamos un hash de la contraseña
    return hash("sha256", $password);
  }

  public function hashPassword($password)
  {
    // Retornamos la contraseña encriptada
    return password_hash(self::preparePlainPassword($password), PASSWORD_BCRYPT);
  }

  public function verifyPassword($password, $hash)
  {
    // Retornamos si la contraseña es válida
    return password_verify(self::preparePlainPassword($password), $hash);
  }
}
