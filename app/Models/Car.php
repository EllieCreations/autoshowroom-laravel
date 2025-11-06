<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    // Attiviamo i timestamps perché ora ci sono nel DB
    public $timestamps = true;

    protected $fillable = [
        'brand_id',
        'model',
        'car_type_id',
        'fuel_type_id',
        'transmission_id',
        'year',
        'price',
        'km',
        'seats',
        'power_kw',
        'car_condition',
        'description',
        'slug',
        'highlighted',
    ];

    // === RELAZIONI ===
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_id');
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function transmission()
    {
        return $this->belongsTo(Transmission::class, 'transmission_id');
    }

    public function images()
    {
        return $this->hasMany(CarImage::class, 'car_id');
    }

    public function primaryImage()
    {
        return $this->hasOne(CarImage::class, 'car_id')->where('is_primary', 1);
    }
    
    protected static function booted()
    {
        static::deleting(function ($car) {
            foreach ($car->images as $image) {
                $path = public_path($image->image_path);
                if (file_exists($path)) {
                    @unlink($path);
                }
            }

            $dir = storage_path("app/public/cars/{$car->id}");
            if (is_dir($dir)) {
                @array_map('unlink', glob("$dir/*.*"));
                @rmdir($dir);
            }

            $car->images()->delete();
        });
    }

}
