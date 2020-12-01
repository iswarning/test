<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juridical extends Model
{
    use HasFactory;
    protected $table = "juridical";
    protected $fillable = [
        'contract_info',
        'status',
        'notarized_date',
        'registration_procedures',
        'liquidation',
        'bill_profile',
        'book_holder',
        'delivery_land_date',
        'delivery_book_date',
        'commitment',
        'contract_id'
    ];
}
