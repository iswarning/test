<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\Revision;

class Revisions extends Revision
{
    use HasFactory;
    public $table = 'revisions';

    protected $fillable = [
        'revisionable_id'
    ];
}
