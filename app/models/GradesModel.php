<?php

namespace App\Models;

class GradesModel extends BaseModel {
  public function getAllGrades()
  {
    $statement = $this->db->query("SELECT * FROM grades ORDER BY FIELD(_id, 'K', 'PK', '1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th')");
    return $statement->fetchAll();
  }

  public function getByIdGrade($_id)
  {
    $statement = $this->db->prepare("SELECT grade FROM grades WHERE _id = ?");
    $statement->execute([$_id]);
    return $statement->fetchObject();
  }
}
