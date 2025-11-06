<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    use HasFactory;

    protected $table = 'transmissions';
    public $timestamps = false;

    protected $fillable = ['name', 'slug'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'transmission_id');
    }
}
