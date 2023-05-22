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
    // Vamos a guardar el usuario en la base de datos
    $statement = $this->db->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Creamos una instancia de la clase SecurityModel
    $securityModelInstance = new SecurityModel();
    // Obtenemos la contraseña encriptada
    $password = $securityModelInstance->hashPassword($password);
    
    // Ejecutamos la consulta
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

  public function getByEmail($email)
  {
    // Vamos a obtener al usuario por su email
    $statement = $this->db->prepare("SELECT users.name, users.lastname, users.telephone, users.email, users.password, users.role as role_id, roles.role, roles.permissions FROM users INNER JOIN roles ON users.role = roles._id WHERE users.email = ?");
    // Ejecutamos la consulta
    $statement->execute([$email]);
    // Retornamos el usuario
    return $statement->fetchObject();
  }

  public function findByEmail($email)
  {
    // Vamos a buscar al usuario por su email
    $statement = $this->db->prepare("SELECT _id FROM users WHERE email = ?");
    // Ejecutamos la consulta
    $statement->execute([$email]);
    // Retornamos el usuario
    return $statement->fetchObject();
  }

  public function findById($_id)
  {
    // Vamos a buscar al usuario por su documento de identidad
    $statement = $this->db->prepare("SELECT email FROM users WHERE _id = ?");
    // Ejecutamos la consulta
    $statement->execute([$_id]);
    // Retornamos el usuario
    return $statement->fetchObject();
  }

  public function updatePassword($email, $password)
  {
    // Vamos a actualizar la contraseña del usuario
    $statement = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");
    // Creamos una instancia de la clase SecurityModel
    $securityModelInstance = new SecurityModel();
    // Obtenemos la contraseña encriptada
    $passwordHash = $securityModelInstance->hashPassword($password);
    // Ejecutamos la consulta
    return $statement->execute([
      $passwordHash,
      $email
    ]);
  }
}
