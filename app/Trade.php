<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    public function event()
    {
        return $this->morphOne(Event::class, 'detail');
    }
}
