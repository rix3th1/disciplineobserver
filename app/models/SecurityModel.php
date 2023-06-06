<?php

namespace App\Models;

class SecurityModel {
  public function preparePlainPassword(string $password): string
  {
    // Retornamos un hash de la contraseña
    return hash("sha256", $password);
  }

  public function hashPassword(string $password): string
  {
    // Retornamos la contraseña encriptada
    return password_hash(self::preparePlainPassword($password), PASSWORD_BCRYPT);
  }

  public function verifyPassword(string $password, $hash): bool
  {
    // Retornamos si la contraseña es válida
    return password_verify(self::preparePlainPassword($password), $hash);
  }
}
