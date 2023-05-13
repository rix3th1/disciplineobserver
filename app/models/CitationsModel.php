<?php

namespace App\Models;

class CitationsModel extends BaseModel
{
  public function create($_id, $msg_parent, $email_parent)
  {
    $statement = $this->db->prepare("INSERT INTO citations VALUES (?, ?, ?)");
    return $statement->execute([$_id, $msg_parent, $email_parent]);
  }
}
