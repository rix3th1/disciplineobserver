<?php

namespace App\Models;

class SecurityModel {
  public function preparePlainPassword($password)
  {
    return hash("sha256", $password);
  }

  public function hashPassword($password)
  {
    return password_hash(self::preparePlainPassword($password), PASSWORD_BCRYPT);
  }

  public function verifyPassword($password, $hash)
  {
    return password_verify(self::preparePlainPassword($password), $hash);
  }
}