<?php

namespace App\Models;

class SubjectModel extends BaseModel {
  public function create(
    string $_id,
    string $global_subject_id,
    string $subject_schedule
  ): bool {
    $statement = $this->db->prepare("INSERT INTO subjects (_id, global_subject_id, subject_schedule) VALUES (?, ?, ?)");
    return $statement->execute([
      $_id,
      $global_subject_id,
      $subject_schedule
    ]);
  }
}
