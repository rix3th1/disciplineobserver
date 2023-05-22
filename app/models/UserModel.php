<?php

namespace App\Models;

class UserModel extends BaseModel {
  public function create(
    $_id,
    $name, 
    $lastname,
    $telephone,
    $email,
    $password,
    $role
  )
  {
    $statement = $this->db->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?)");
    $securityModelInstance = new SecurityModel();
    $password = $securityModelInstance->hashPassword($password);
    
    return $statement->execute([
      $_id,
      $name,
      $lastname,
      $telephone,
      $email,
      $password,
      $role
    ]);
  }

  public function findByEmail($email)
  {
    $statement = $this->db->prepare("SELECT users.name, users.lastname, users.telephone, users.email, users.password, users.role as role_id, roles.role, roles.permissions FROM users INNER JOIN roles ON users.role = roles._id WHERE users.email = ?");
    $statement->execute([$email]);
    return $statement->fetchObject();
  }

  public function updatePassword($email, $password)
  {
    $statement = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");
    $securityModelInstance = new SecurityModel();
    $passwordHash = $securityModelInstance->hashPassword($password);
    return $statement->execute([
      $passwordHash,
      $email
    ]);
  }
}
