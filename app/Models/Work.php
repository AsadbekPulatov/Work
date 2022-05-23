<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'command',
        'firm_name',
        'firm_address',
        'firm_phone',
        'firm_year',
        'document',
    ];
}
