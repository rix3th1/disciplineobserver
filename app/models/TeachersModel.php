<?php

namespace App\Models;

class TeachersModel extends UserModel {
  public function getAllTeachers()
  {
    // Obtener todos los usuarios de tipo teacher
    $statement = $this->db->query("SELECT * FROM users WHERE role = 'teacher'");
    // Retornar todos los profesores
    return $statement->fetchAll();
  }

  public function updateTeacher($_id, $name, $lastname, $telephone, $email)
  {
    $statement = $this->db->prepare("UPDATE users SET name = ?, lastname = ?, telephone = ?, email = ? WHERE _id = ?");
    return $statement->execute([
      $name,
      $lastname,
      $telephone,
      $email,
      $_id
    ]);
  }

  public function getTeacherBySearch($search)
  {
    // Buscar profesores por nombre, apellido o email
    $statement = $this->db->prepare("SELECT * FROM users WHERE role = 'teacher' AND (_id = ? OR name LIKE ? OR lastname LIKE ? OR email LIKE ?)");
    // Ejecutar la consulta
    $statement->execute([
      $search,
      "$search%",
      "$search%",
      "$search%"
    ]);
    // Retornar los resultados
    return $statement->fetchAll();
  }

  public function getTeacherById($_id)
  {
    // Buscar profesor por id
    $statement = $this->db->prepare("SELECT * FROM users WHERE role = 'teacher' AND _id = ?");
    // Ejecutar la consulta
    $statement->execute([$_id]);
    // Retornar los resultados
    return $statement->fetchObject();
  }

  public function deleteTeacher($_id)
  {
    // Eliminar profesor
    $statement = $this->db->prepare("DELETE FROM users WHERE role = 'teacher' AND _id = ?");
    // Ejecutar la consulta
    return $statement->execute([$_id]);
  }
}