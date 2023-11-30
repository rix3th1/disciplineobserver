<?php

namespace App\Models;

class GlobalSubjectModel extends BaseModel {
  public function getAllGlobalSubjects(
  ): array {
    $statement = $this->db->query("SELECT * FROM global_subjects");
    return $statement->fetchAll();
  }
}
