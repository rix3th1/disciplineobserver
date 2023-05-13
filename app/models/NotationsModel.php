<?php

namespace App\Models;

class NotationsModel extends BaseModel
{
  public function create($_id, $notation, $grade, $testimony)
  {
    $statement = $this->db->prepare("INSERT INTO notations(_id, notation, grade, testimony) VALUES (?, ?, ?, ?)");
    return $statement->execute([$_id, $notation, $grade, $testimony]);
  }

  public function findNotationsByStudent($_id)
  {
    $statement = $this->db->query("SET @row_number = 0");
    $statement = $this->db->prepare("SELECT @row_number:=@row_number+1 as number, students._id, notations.notation, students.student, notations.testimony FROM notations INNER JOIN students ON notations._id = students._id WHERE students._id = ? ORDER BY notations.created_at DESC");
    $statement->execute([$_id]);
    return $statement->fetchAll();
  }
}
