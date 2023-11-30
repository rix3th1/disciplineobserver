<?php

namespace App\Models;

class StudentsModel extends BaseModel {
  public function create(
    string $_id,
    string $student,
    string $grade,
    string $parent_id
  ): bool
  {
    // Vamos a crear un nuevo estudiante en la base de datos
    $statement = $this->db->prepare("INSERT INTO students (_id, student, grade, parent_id) VALUES (?, ?, ?, ?)");
    // Ejecutamos la consulta y retornamos el resultado
    return $statement->execute([
      $_id,
      $student,
      $grade,
      $parent_id
    ]);
  }

  public function getAllStudents(): array
  {
    $statement = $this->db->query("SELECT S._id, S.student, S.grade, S.parent_id, S.is_enabled, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email FROM students as S INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id");
    return $statement->fetchAll();
  }

  public function getStudentByGrade(string $grade): array
  {
    $statement = $this->db->prepare("SELECT S._id, S.student, S.grade, S.parent_id, S.is_enabled, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email FROM students as S INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id WHERE S.grade = ?");
    $statement->execute([$grade]);
    return $statement->fetchAll();
  }

  public function getStudentBySearchAdmin(string $search): array
  {
    $statement = $this->db->prepare("SELECT S._id, S.student, S.grade, S.parent_id, S.is_enabled, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email FROM students as S INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id WHERE (S._id = ? OR S.student LIKE ? OR S.grade LIKE ?)");
    $statement->execute([
      $search,
      "$search%",
      "$search%"
    ]);
    return $statement->fetchAll();
  }

  public function getStudentByParent(string $parent_id): array
  {
    $statement = $this->db->prepare("SELECT S._id, S.student, S.grade, S.parent_id, S.is_enabled, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email FROM students as S INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id WHERE S.parent_id = ? AND S.is_enabled = 1");
    $statement->execute([$parent_id]);
    return $statement->fetchAll();
  }

  public function getStudentByParentWithCitation(string $parent_id): array
  {
    $statement = $this->db->prepare("SELECT S._id, S.student, S.grade, S.parent_id, S.is_enabled, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email, CIT.resolved as citation_pending FROM students as S INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id LEFT JOIN citations as CIT ON CIT.student_id = S._id WHERE S.parent_id = ? AND S.is_enabled = 1");
    $statement->execute([$parent_id]);
    return $statement->fetchAll();
  }

  public function getStudentEnabledByDocumentOrName(string $search): array
  {
    $statement = $this->db->prepare("SELECT S._id, S.student, S.grade, S.parent_id, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email FROM students as S INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id WHERE (S._id = ? OR S.student LIKE ?) AND S.is_enabled = 1");
    $statement->execute([
      $search,
      "$search%"
    ]);
    return $statement->fetchAll();
  }

  public function getStudentEnabledByDocumentOrNameWithCitation(string $search): array
  {
    $statement = $this->db->prepare("SELECT S._id, S.student, S.grade, S.parent_id, U.name as parent_name, U.lastname as parent_lastname, U.email as parent_email, CIT.resolved as citation_pending FROM students as S INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id LEFT JOIN citations as CIT ON CIT.student_id = S._id WHERE (S._id = ? OR S.student LIKE ?) AND S.is_enabled = 1");
    $statement->execute([
      $search,
      "$search%"
    ]);
    return $statement->fetchAll();
  }

  public function getByIdStudent(string $_id): object | bool
  {
    // Obtenemos el estudiante por su id
    $statement = $this->db->prepare("SELECT S._id, S.student, S.grade, S.parent_id, S.is_enabled, U.name as parent_name, PS.days_available, PS.availability_start_time, PS.availability_end_time, U.lastname as parent_lastname, U.email as parent_email FROM students as S INNER JOIN parents_students as PS ON S.parent_id = PS._id INNER JOIN users as U ON U._id = PS._id WHERE S._id = ?");
    // Ejecutamos la consulta y retornamos el resultado
    $statement->execute([$_id]);
    // Retornamos al estudiante
    return $statement->fetchObject();
  }

  public function updateStudent(
    string $_id,
    string $student,
    string $grade
  ): bool
  {
    $statement = $this->db->prepare("UPDATE students SET student = ?, grade = ? WHERE _id = ?");
    return $statement->execute([
      $student,
      $grade,
      $_id
    ]);
  }

  public function deleteStudent(string $_id): bool
  {
    $statement = $this->db->prepare("DELETE FROM students WHERE _id = ?");
    return $statement->execute([$_id]);
  }

  public function changeStudentState(string $_id, bool $is_enabled): bool
  {
    $statement = $this->db->prepare("UPDATE students SET is_enabled = ? WHERE _id = ?");
    return $statement->execute([$is_enabled, $_id]);
  }
}
