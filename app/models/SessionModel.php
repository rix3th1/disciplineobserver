<?php

namespace App\Models;

// Importamos la clase Exception de PHP
use Exception;

class SessionModel extends BaseModel {
  public function getAllRoles() {
    // Seleccionamos todos los roles
    $statement = $this->db->query("SELECT * FROM roles");
    // Retornamos los roles
    return $statement->fetchAll();
  }

  public function auth(
    $email,
    $password
  )
  {
    // Creamos una instancia del Modelo User
    $userModelInstance = new UserModel();
    // Buscar el usuario por el email
    $dataUser = $userModelInstance->getByEmail($email);
    $securityModelInstance = new SecurityModel();

    // Verificamos que el usuario exista
    if ($dataUser) {
      // Verificamos que el cargo sea correcto
      if ($dataUser->role_id !== $_POST['post']) {
        // Si el cargo es incorrecto lanzamos una excepción
        throw new Exception("El cargo que seleccionó es incorrecto"); 
      }
    }

    // Verificamos que la contraseña sea correcta y que el usuario exista
    if ($dataUser && $securityModelInstance->verifyPassword($password, $dataUser->password)) {
      // Si todo es correcto creamos la sesión y obtenemos los permisos
      $permissions = explode(',', $dataUser->permissions);
      $this->sessionStart();

      // Guardamos los datos del usuario en la sesión
      return $_SESSION['user_discipline_observer'] = [
        'name' => $dataUser->name,
        'lastname' => $dataUser->lastname,
        'telephone' => $dataUser->telephone,
        'email' => $dataUser->email,
        'role' => $dataUser->role,
        'permissions' => $permissions
      ];
    }

    // Si no es correcto lanzamos una excepción
    throw new Exception("El correo o la contraseña son incorrectas");    
  }

  public function sessionStart()
  {
    // Iniciamos la sesión
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  public function logOut()
  {
    // Destruimos la sesión
    $this->sessionStart();
    session_destroy();
  }
}
