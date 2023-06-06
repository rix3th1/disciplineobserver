<?php

namespace App\Models;

class GradesModel extends BaseModel {
  public function getAllGrades(): array
  {
    // Seleccionamos todos los grados en orden
    $statement = $this->db->query("SELECT * FROM grades ORDER BY FIELD(_id, 'K', 'PK', '1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th')");
    // Retornamos todos los grados
    return $statement->fetchAll();
  }

  public function getByIdGrade(string $_id): object | bool
  {
    // Seleccionamos el grado por id
    $statement = $this->db->prepare("SELECT grade FROM grades WHERE _id = ?");
    // Ejecutamos la consulta
    $statement->execute([$_id]);
    // Retornamos el grado
    return $statement->fetchObject();
  }
}
