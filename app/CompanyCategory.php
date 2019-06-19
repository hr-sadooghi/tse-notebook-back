<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
