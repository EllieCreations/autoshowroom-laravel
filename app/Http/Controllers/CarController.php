<?php

namespace App\Http\Controllers;

use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with(['brand', 'images', 'fuelType', 'carType'])->paginate(12);
        return view('cars.index', compact('cars'));
    }

    public function show($id)
    {
        $car = Car::with(['brand', 'images', 'fuelType', 'carType', 'transmission'])
            ->findOrFail($id);
        
        return view('cars.show', compact('car'));
    }
}