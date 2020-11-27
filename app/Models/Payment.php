<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = "payments";
    protected $fillable = [
        'payment_progress',
        'payment_date_95',
        'day_late',
        'batch_late',
        'money_late',
        'citation_rate',
        'number_notifi',
        'document',
        'receipt_date',
        'contract_id'
    ];
}
