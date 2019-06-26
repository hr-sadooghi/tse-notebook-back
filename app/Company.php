<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $hidden = ['pivot'];

    public function category()
    {
        return $this->belongsTo(CompanyCategory::class, 'category_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
