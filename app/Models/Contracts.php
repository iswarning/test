<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Contracts extends Model
{
    use HasFactory, RevisionableTrait;

    protected $table = "contracts";
    protected $revisionEnabled = true;

    protected $fillable = [
        'contract_no',
        'type',
        'lot_number',
        'area_signed',
        'status',
        'signed',
        'signed_date',
        'status_created_by',
        'value',
        'customer_id',
        'project_id'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customers');
    }

    public function project()
    {
        return $this->hasOne('App\Models\Project','project_id');
    }

    public function payment()
    {
        return $this->belongsTo('App\Models\Payment');
    }
}
