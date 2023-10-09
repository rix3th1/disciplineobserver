<?php

namespace App\Models;

class CitationsModel extends BaseModel {
  public function create(
    string $_id,
    string $citation_date,
    string $msg_parent
  ): bool
  {
    // Preparamos la consulta
    $statement = $this->db->prepare("INSERT INTO citations(_id, citation_date, msg_parent) VALUES (?, ?, ?)");
    // Ejecutamos la consulta y retornamos el resultado
    return $statement->execute([
      $_id,
      $citation_date,
      $msg_parent
    ]);
  }
  
  public function findCitationsByStudent(string $_id): array
  {
    // Establecemos un contador de citaciones
    $statement = $this->db->query("SET @row_number = 0");
    // Preparamos la consulta
    $statement = $this->db->prepare("SELECT @row_number:=@row_number+1 as number, CIT._id, NOTA.notation, S.student, NOTA.testimony, CIT.msg_parent, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email, U._id as parent_id FROM citations as CIT INNER JOIN students as S ON CIT._id = S._id INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id INNER JOIN notations as NOTA ON CIT._id = NOTA._id AND CIT.created_at = NOTA.created_at WHERE S._id = ? ORDER BY NOTA.created_at DESC");
    // Ejecutamos la consulta
    $statement->execute([$_id]);
    // Retornamos los resultados
    return $statement->fetchAll();
  }

  public function insertAvailability($job, $availability_parent) {
  $statement = $this->db->prepare("INSERT INTO `availability`(`job`, `availability_parent`) VALUES (?, ?, ?, ?)");
  // Ejecutamos la consulta y retornamos el resultado
  return $statement->execute([
    $job,
    $availability_parent
    ]);
  }
}