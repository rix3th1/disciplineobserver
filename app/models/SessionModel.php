<?php

namespace App\Models;

class SessionModel extends BaseModel {
  public function auth()
  {
    return 'Authenticated word';
  }
}