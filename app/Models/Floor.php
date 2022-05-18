<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;
    protected $fillable = ['bino_id','floor'];

    public function bino(){
        return $this->belongsTo(Bino::class);
    }

    public function rooms(){
        return $this->hasMany(Room::class);
    }

}
