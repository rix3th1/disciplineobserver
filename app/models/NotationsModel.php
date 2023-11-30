<?php

namespace App\Models;

class NotationsModel extends BaseModel {
  public function create(
    string $student_id,
    string $notation,
    string $grade,
    string $testimony,
    string $severity_level,
    string $teacher_name,
    string $subject_id
  ): bool
  {
    // Consulta para crear una anotación
    $statement = $this->db->prepare("INSERT INTO notations(student_id, notation, grade, testimony, severity_level, teacher_name, subject_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Ejecutar la consulta
    return $statement->execute([
      $student_id,
      $notation,
      $grade,
      $testimony,
      $severity_level,
      $teacher_name,
      $subject_id
    ]);
  }

  public function delete(string $_id, string $created_at): bool
  {
    // Consulta para eliminar una anotación
    $statement = $this->db->prepare("DELETE FROM notations WHERE _id = ? AND created_at = ?");
    // Ejecutar la consulta
    return $statement->execute([$_id, $created_at]);
  }

  public function getNumberOfNotations(string $_id): int
  {
    // Consulta para obtener el número de anotaciones de un estudiante
    $statement = $this->db->prepare("SELECT COUNT(*) as total FROM notations WHERE _id = ?");
    // Ejecutar la consulta
    $statement->execute([$_id]);
    // Obtener el número de anotaciones
    return $statement->fetchColumn();
  }

  public function findNotationsByStudent(string $_id): array
  {
    // Este cálculo sirve para que el nÚmero de filas se muestren en orden ascendente
    $statement = $this->db->query("SET @row_number = 0");
    // Preparamos la consulta para que reciba el id del estudiante
    $statement = $this->db->prepare("SELECT @row_number:=@row_number+1 as number, S._id, NOTA.notation, NOTA.severity_level, S.student, NOTA.testimony, NOTA.created_at, NOTA.teacher_name, GS._id as subject_id, GS.subject_name, SUBJ.subject_schedule FROM notations as NOTA INNER JOIN students as S ON NOTA.student_id = S._id INNER JOIN subjects as SUBJ ON SUBJ._id = NOTA.subject_id INNER JOIN global_subjects as GS ON GS._id = SUBJ.global_subject_id WHERE S._id = ? ORDER BY NOTA.created_at DESC");
    // Ejecutar la consulta
    $statement->execute([$_id]);
    // Devolver los resultados
    return $statement->fetchAll();
  }
}
