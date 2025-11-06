<?php

namespace App\Http\Controllers;

use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        // Prende TUTTE le auto in evidenza
        $latestCars = Car::query()
            ->with(['brand', 'images', 'fuelType', 'carType'])
            ->where('highlighted', 1)
            ->orderBy('created_at', 'desc')
            ->get(); // Prendi tutte, poi limiti nella view
        
        // Se non ci sono auto in evidenza, prendi tutte
        if ($latestCars->isEmpty()) {
            $latestCars = Car::query()
                ->with(['brand', 'images', 'fuelType', 'carType'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('home', compact('latestCars'));
    }
}