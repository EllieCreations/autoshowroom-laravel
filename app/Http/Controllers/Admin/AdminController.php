<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;

class AdminController extends Controller
{
    public function index()
    {
        // Recupera le ultime 3 auto
        $latestCars = Car::with('brand')->orderByDesc('id')->take(3)->get();

        // Mostra la dashboard con le auto recenti
        return view('admin.dashboard', compact('latestCars'));
    }
}
