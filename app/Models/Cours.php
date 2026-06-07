<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'cours'; 
    protected $fillable = ['name', 'coach', 'day', 'time', 'capacity'];

   
public function reservations() {
    return $this->hasMany(Reservation::class, 'cours_id');
}
}