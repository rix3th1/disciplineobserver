<?php

namespace App\Models;

class SubjectModel extends BaseModel {
  public function create(
    string $_id,
    string $subject_name,
    string $subject_schedule
  ): bool {
    $statement = $this->db->prepare("INSERT INTO subjects (_id, subject_name, subject_schedule) VALUES (?, ?, ?)");
    return $statement->execute([
      $_id,
      $subject_name,
      $subject_schedule
    ]);
  }
}
