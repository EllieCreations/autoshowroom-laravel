<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    use HasFactory;

    protected $table = 'car_types';
    public $timestamps = false;

    protected $fillable = ['name', 'slug'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'car_type_id');
    }
}
