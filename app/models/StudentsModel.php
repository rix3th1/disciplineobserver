<?php

namespace App\Models;

class StudentsModel extends BaseModel
{
  public function create($_id, $student)
  {
    $statement = $this->db->prepare("INSERT INTO students VALUES (?, ?)");
    return $statement->execute([$_id, $student]);
  }

  public function getByIdStudent($_id)
  {
    $statement = $this->db->prepare("SELECT student FROM students WHERE _id = ?");
    $statement->execute([$_id]);
    return $statement->fetchObject();
  }
}
