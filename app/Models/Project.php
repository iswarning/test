<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "projects";
    protected $fillable = [
        'name',
        'description'
    ];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contracts');
    }
}
