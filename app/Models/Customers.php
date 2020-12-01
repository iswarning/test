<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "customers";
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'birthday',
        'cmnd',
        'household',
        'phone'
    ];

    public function contracts()
    {
        return $this->hasMany('App\Models\Contracts', 'customer_id');
    }
}
