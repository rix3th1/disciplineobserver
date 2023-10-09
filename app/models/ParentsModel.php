<?php

namespace App\Models;

class ParentsModel extends BaseModel {
  public function create(
    string $_id,
    string $job,
    string $availability
  ): bool {
    $statement = $this->db->prepare("INSERT INTO parents_students (_id, job, availability) VALUES (?, ?, ?)");
    return $statement->execute([
      $_id,
      $job,
      $availability
    ]);
  }

  public function getAllParents(): array
  {
    $statement = $this->db->query("SELECT * FROM users INNER JOIN parents_students ON users._id = parents_students._id WHERE role = 'parent'");
    return $statement->fetchAll();
  }

  public function updateParent(
    string $_id,
    string $name,
    string $lastname,
    string $telephone,
    string $email,
    string $job,
    string $availability
  ): bool
  {
    $statement = $this->db->prepare("UPDATE users SET name = ?, lastname = ?, telephone = ?, email = ? WHERE _id = ?");
    $statement2 = $this->db->prepare("UPDATE parents_students SET job = ?, availability = ? WHERE _id = ?");

    return $statement->execute([
      $name,
      $lastname,
      $telephone,
      $email,
      $_id
    ]) && $statement2->execute([
      $job,
      $availability,
      $_id
    ]);
  }

  public function getParentBySearch(string $search): array
  {
    $statement = $this->db->prepare("SELECT * FROM users INNER JOIN parents_students ON users._id = parents_students._id WHERE users.role = 'parent' AND (users._id = ? OR users.name LIKE ? OR users.lastname LIKE ? OR users.email LIKE ?)");
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
    U._id, U.name, U.lastname, U.telephone, U.email, PS.job, PS.availability FROM users U INNER JOIN parents_students PS ON U._id = PS._id WHERE U.role = 'parent' AND U._id = ?");
    $statement->execute([$_id]);
    return $statement->fetchObject();
  }

  public function deleteParent(string $_id): bool
  {
    $statement = $this->db->prepare("DELETE FROM users WHERE role = 'parent' AND _id = ?");
    return $statement->execute([$_id]);
  }
}