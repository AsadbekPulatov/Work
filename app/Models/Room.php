<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['room_number','count'];

    public function attendances(){
        return $this->hasMany(Attendance::class)->orderBy('created_at', 'DESC');
    }
    public function floor(){
        return $this->belongsTo(Floor::class,'floor_id');
    }
}
