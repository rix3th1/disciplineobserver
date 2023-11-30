<?php

namespace App\Models;

class CitationsModel extends BaseModel {
  public function create(
    string $student_id,
    string $citation_date,
    string $msg_parent
  ): bool
  {
    // Preparamos la consulta
    $statement = $this->db->prepare("INSERT INTO citations(student_id, citation_date, msg_parent) VALUES (?, ?, ?)");
    // Ejecutamos la consulta y retornamos el resultado
    return $statement->execute([
      $student_id,
      $citation_date,
      $msg_parent
    ]);
  }

  public function getNumberOfCitations(string $_id): int
  {
    // Obtenemos el número de citaciones de un estudiante
    $statement = $this->db->prepare("SELECT COUNT(*) as total FROM citations WHERE _id = ?");
    // Ejecutamos la consulta
    $statement->execute([$_id]);
    // Retornamos el resultado
    return $statement->fetchColumn();
  }

  public function resolveCitation(string $id, bool $resolved): bool
  {
    $statement = $this->db->prepare("UPDATE citations SET resolved = ? WHERE student_id = ?");
    return $statement->execute([$resolved, $id]);
  }

  public function findCitationsByStudent(string $_id): array
  {
    // Establecemos un contador de citaciones
    $statement = $this->db->query("SET @row_number = 0");
    // Preparamos la consulta
    $statement = $this->db->prepare("SELECT @row_number:=@row_number+1 as number, CIT.student_id as _id, NOTA.notation, NOTA.severity_level, S.student, S.grade, NOTA.testimony, CIT.msg_parent, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email, U._id as parent_id, NOTA.teacher_name, SUBJ.subject_name, SUBJ.subject_schedule, CIT.resolved FROM citations as CIT INNER JOIN students as S ON CIT.student_id = S._id INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id INNER JOIN notations as NOTA ON CIT.student_id = NOTA.student_id AND CIT.created_at = NOTA.created_at INNER JOIN subjects as SUBJ ON SUBJ._id = NOTA.subject_id WHERE S._id = ? ORDER BY NOTA.created_at DESC");
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