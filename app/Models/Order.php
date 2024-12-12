<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'ip',
        'sub_total',
        'status',
    ];
}