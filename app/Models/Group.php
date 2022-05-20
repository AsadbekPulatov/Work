<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'faculty_id', 'employee_id'
    ];

    public function faculty(){
        return $this->belongsTo(Fakultet::class);
    }
}
