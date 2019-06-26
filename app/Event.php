<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function detail()
    {
        return $this->morphTo();
    }
}
