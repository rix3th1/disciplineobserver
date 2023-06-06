<?php

namespace App\Models;

class NotationsModel extends BaseModel {
  public function create(
    string $_id,
    string $notation,
    string $grade,
    string $testimony
  ): bool
  {
    // Consulta para crear una anotación
    $statement = $this->db->prepare("INSERT INTO notations(_id, notation, grade, testimony) VALUES (?, ?, ?, ?)");
    // Ejecutar la consulta
    return $statement->execute([$_id, $notation, $grade, $testimony]);
  }

  public function findNotationsByStudent(string $_id): array
  {
    // Este cálculo sirve para que el nÚmero de filas se muestren en orden ascendente
    $statement = $this->db->query("SET @row_number = 0");
    // Preparamos la consulta para que reciba el id del estudiante
    $statement = $this->db->prepare("SELECT @row_number:=@row_number+1 as number, students._id, notations.notation, students.student, notations.testimony FROM notations INNER JOIN students ON notations._id = students._id WHERE students._id = ? ORDER BY notations.created_at DESC");
    // Ejecutar la consulta
    $statement->execute([$_id]);
    // Devolver los resultados
    return $statement->fetchAll();
  }
}
