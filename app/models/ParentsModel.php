<?php

namespace App\Models;

class ParentsModel extends BaseModel {
  public function getAllParents(): array
  {
    $statement = $this->db->query("SELECT * FROM users WHERE role = 'parent'");
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
    return $statement->execute([
      $name,
      $lastname,
      $telephone,
      $email,
      $job,
      $availability,
      $_id
    ]);
  }

  public function getParentBySearch(string $search): array
  {
    $statement = $this->db->prepare("SELECT * FROM users WHERE role = 'parent' AND (_id = ? OR name LIKE ? OR lastname LIKE ? OR email LIKE ?)");
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
    $statement = $this->db->prepare("SELECT * FROM users WHERE role = 'parent' AND _id = ?");
    $statement->execute([$_id]);
    return $statement->fetchObject();
  }

  public function deleteParent(string $_id): bool
  {
    $statement = $this->db->prepare("DELETE FROM users WHERE role = 'parent' AND _id = ?");
    return $statement->execute([$_id]);
  }
}