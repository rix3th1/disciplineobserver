<?php

namespace App\Models;

class CitationsModel extends BaseModel
{
  public function create($_id, $msg_parent, $email_parent)
  {
    $statement = $this->db->prepare("INSERT INTO citations(_id, msg_parent, email_parent) VALUES (?, ?, ?)");
    return $statement->execute([$_id, $msg_parent, $email_parent]);
  }
  
  public function findCitationsByStudent($_id)
  {
    $statement = $this->db->query("SET @row_number = 0");
    $statement = $this->db->prepare("SELECT @row_number:=@row_number+1 as number, citations._id, notations.notation, students.student, notations.testimony, citations.msg_parent, citations.email_parent FROM citations INNER JOIN students ON citations._id = students._id INNER JOIN notations ON citations._id = notations._id AND citations.created_at = notations.created_at WHERE students._id = ? ORDER BY notations.created_at DESC");
    $statement->execute([$_id]);
    return $statement->fetchAll();
  }
}
