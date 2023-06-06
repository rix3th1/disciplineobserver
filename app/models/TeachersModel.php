<?php

namespace App\Models;

class TeachersModel extends UserModel {
  public function getAllTeachers(): array
  {
    // Obtener todos los usuarios de tipo teacher
    $statement = $this->db->query("SELECT * FROM users WHERE role = 'teacher'");
    // Retornar todos los profesores
    return $statement->fetchAll();
  }

  public function updateTeacher(
    $_id,
    string $name,
    string $lastname,
    string $telephone,
    string $email
  ): bool
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

  public function getTeacherBySearch(string $search): array
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

  public function getTeacherById(string $_id): object | bool
  {
    // Buscar profesor por id
    $statement = $this->db->prepare("SELECT * FROM users WHERE role = 'teacher' AND _id = ?");
    // Ejecutar la consulta
    $statement->execute([$_id]);
    // Retornar los resultados
    return $statement->fetchObject();
  }

  public function deleteTeacher(string $_id): bool
  {
    // Eliminar profesor
    $statement = $this->db->prepare("DELETE FROM users WHERE role = 'teacher' AND _id = ?");
    // Ejecutar la consulta
    return $statement->execute([$_id]);
  }
}