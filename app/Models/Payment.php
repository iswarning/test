<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Payment extends Model
{
    use HasFactory, RevisionableTrait;
    protected $table = "payments";
    protected $revisionEnabled = true;
    protected $fillable = [
        'payment_progress',
        'payment_date_95',
        'contract_id',
        'payment_status'
    ];
}
