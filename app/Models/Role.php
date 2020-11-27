<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "roles";
    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->hasMany('App\Models\Permission', 'role_id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'type');
    }
}
