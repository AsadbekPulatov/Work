<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bino extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function floor(){
        return $this->hasMany(Floor::class);
    }
}
