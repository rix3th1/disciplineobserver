<?php

namespace App\Models;

class StudentsModel extends BaseModel
{
  public function create($_id, $student,  $email_parent, $name_parent)
  {
    // Vamos a crear un nuevo estudiante en la base de datos
    $statement = $this->db->prepare("INSERT INTO students VALUES (?, ?, ?, ?)");
    // Ejecutamos la consulta y retornamos el resultado
    return $statement->execute([$_id, $student,  $email_parent, $name_parent]);
  }

  public function getByIdStudent($_id)
  {
    // Obtenemos el estudiante por su id
    $statement = $this->db->prepare("SELECT student, email_parent, name_parent FROM students WHERE _id = ?");
    // Ejecutamos la consulta y retornamos el resultado
    $statement->execute([$_id]);
    // Retornamos al estudiante
    return $statement->fetchObject();
  }
}
