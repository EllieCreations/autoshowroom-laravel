<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;

    protected $table = 'car_images';
    public $timestamps = true;

    protected $fillable = [
        'car_id',
        'image_path',
        'alt_text',
        'is_primary',
        'sort_order',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
