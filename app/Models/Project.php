<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use \Venturecraft\Revisionable\RevisionableTrait;


class Project extends Model
{
    use HasFactory;
    // use RevisionableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "projects";
    // protected $revisionEnabled = true;

    protected $fillable = [
        'name',
        'description'
    ];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contracts');
    }
}
