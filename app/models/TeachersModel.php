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

  public function getTeacherBySearch($search)
  {
    $statement = $this->db->prepare("SELECT * FROM users WHERE role = 'teacher' AND _id = ? OR name LIKE ? OR lastname LIKE ? OR email LIKE ?");
    $statement->execute([
      $search,
      "$search%", 
      "$search%",
      "$search%"
    ]);
    return $statement->fetchAll();
  }

  public function addTeacher($data)
  {

  }

  public function deleteTeacher($_id)
  {
    $statement = $this->db->prepare("DELETE FROM users WHERE role = 'teacher' AND _id = ?");
    return $statement->execute([$_id]);
  }
}