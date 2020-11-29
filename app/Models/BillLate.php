<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillLate extends Model
{
    use HasFactory;
    protected $table = "bill_late";
    protected $fillable = [
        'day_late',
        'batch_late',
        'money_late',
        'citation_rate',
        'number_notifi',
        'document',
        'receipt_date',
        'payment_id'
    ];
}
