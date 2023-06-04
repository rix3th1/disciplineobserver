<?php

namespace App\Models;

class StudentsModel extends BaseModel {
  public function create($_id, $student, $grade, $name_parent, $email_parent,)
  {
    // Vamos a crear un nuevo estudiante en la base de datos
    $statement = $this->db->prepare("INSERT INTO students (_id, student, grade, name_parent, email_parent) VALUES (?, ?, ?, ?, ?)");
    // Ejecutamos la consulta y retornamos el resultado
    return $statement->execute([
      $_id,
      $student,
      $grade,
      $name_parent,
      $email_parent
    ]);
  }

  public function getAllStudents()
  {
    $statement = $this->db->query("SELECT * FROM students");
    return $statement->fetchAll();
  }

  public function getStudentBySearch($search)
  {
    $statement = $this->db->prepare("SELECT * FROM students WHERE (_id = ? OR student LIKE ? OR grade LIKE ?)");
    $statement->execute([
      $search,
      "$search%",
      "$search%"
    ]);
    return $statement->fetchAll();
  }

  public function getByIdStudent($_id)
  {
    // Obtenemos el estudiante por su id
    $statement = $this->db->prepare("SELECT _id, student, grade, name_parent, email_parent FROM students WHERE _id = ?");
    // Ejecutamos la consulta y retornamos el resultado
    $statement->execute([$_id]);
    // Retornamos al estudiante
    return $statement->fetchObject();
  }

  public function updateStudent($_id, $student, $grade, $name_parent, $email_parent)
  {
    $statement = $this->db->prepare("UPDATE students SET student = ?, grade = ?, name_parent = ?, email_parent = ? WHERE _id = ?");
    return $statement->execute([
      $student,
      $grade,
      $name_parent,
      $email_parent,
      $_id
    ]);
  }

  public function deleteStudent($_id)
  {
    $statement = $this->db->prepare("DELETE FROM students WHERE _id = ?");
    return $statement->execute([$_id]);
  }
}
