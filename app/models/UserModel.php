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
    $statement = $this->db->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $permissions = $this->definePermissions($role);
    $securityModelInstance = new SecurityModel();
    $password = $securityModelInstance->hashPassword($password);
    
    return $statement->execute([
      $_id,
      $name,
      $lastname,
      $telephone,
      $email,
      $password,
      $role,
      $permissions
    ]);
  }

  public function getByEmail($email)
  {
    $statement = $this->db->prepare("SELECT * FROM users WHERE email = ?");
    $statement->execute([$email]);
    return $statement->fetchObject();
  }

  public function definePermissions($role)
  {
    return $role === "parent"
    ?
    "view_observer,view_cite_parents"
    :
    "make_notation,cite_parents,view_observer,view_cite_parents";
  }
}