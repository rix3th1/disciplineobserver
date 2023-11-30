<?php

namespace App\Models;

class ParentsModel extends BaseModel {
  public function create(
    string $_id,
    string $job,
    string $days_available,
    string $availability_start_time,
    string $availability_end_time,
  ): bool {
    $statement = $this->db->prepare("INSERT INTO parents_students (_id, job, days_available, availability_start_time, availability_end_time) VALUES (?, ?, ?, ?, ?)");
    return $statement->execute([
      $_id,
      $job,
      $days_available,
      $availability_start_time,
      $availability_end_time,
    ]);
  }

  public function getAllParents(): array
  {
    $statement = $this->db->query("SELECT * FROM users as U INNER JOIN parents_students as PS ON U._id = PS._id WHERE U.role = 'parent'");
    return $statement->fetchAll();
  }

  public function updateParent(
    string $_id,
    string $name,
    string $lastname,
    string $telephone,
    string $email,
    string $job,
    string $days_available,
    string $availability_start_time,
    string $availability_end_time,
  ): bool
  {
    $statement = $this->db->prepare("UPDATE users SET name = ?, lastname = ?, telephone = ?, email = ? WHERE _id = ?");
    $statement2 = $this->db->prepare("UPDATE parents_students SET job = ?, days_available = ?, availability_start_time = ?, availability_end_time = ? WHERE _id = ?");

    return $statement->execute([
      $name,
      $lastname,
      $telephone,
      $email,
      $_id
    ]) && $statement2->execute([
      $job,
      $days_available,
      $availability_start_time,
      $availability_end_time,
      $_id
    ]);
  }

  public function getParentBySearch(string $search): array
  {
    $statement = $this->db->prepare("SELECT * FROM users as U INNER JOIN parents_students as PS ON U._id = PS._id WHERE U.role = 'parent' AND (U._id = ? OR U.name LIKE ? OR U.lastname LIKE ? OR U.email LIKE ?)");
    $statement->execute([
      $search,
      "$search%",
      "$search%",
      "$search%"
    ]);
    return $statement->fetchAll();
  }

  public function getParentById(string $_id): object | bool
  {
    $statement = $this->db->prepare("SELECT 
    U._id, U.name, U.lastname, U.telephone, U.email, PS.job, PS.days_available, PS.availability_start_time, PS.availability_end_time FROM users U INNER JOIN parents_students PS ON U._id = PS._id WHERE U.role = 'parent' AND U._id = ?");
    $statement->execute([$_id]);
    return $statement->fetchObject();
  }

  public function deleteParent(string $_id): bool
  {
    $statement = $this->db->prepare("DELETE FROM users WHERE role = 'parent' AND _id = ?");
    return $statement->execute([$_id]);
  }
}
