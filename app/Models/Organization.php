<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function users(){
        return $this->hasMany(User::class);
    }

    public function packages()
    {
        return $this->hasOne(package::class);
    }
}
