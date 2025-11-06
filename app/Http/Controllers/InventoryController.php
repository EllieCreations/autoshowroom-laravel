<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use App\Models\CarType;
use App\Models\FuelType;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['brand', 'images', 'fuelType', 'carType', 'transmission']);

        // Filtro ricerca generale
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('brand', function($brandQuery) use ($search) {
                    $brandQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('model', 'like', "%{$search}%")
                ->orWhere('year', 'like', "%{$search}%");
            });
        }

        // Filtro marca
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Filtro tipo auto
        if ($request->filled('car_type')) {
            $query->where('car_type_id', $request->car_type);
        }

        // Filtro carburante
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type_id', $request->fuel_type);
        }

        // Filtro condizione
        if ($request->filled('condition')) {
            $query->where('car_condition', $request->condition);
        }

        // Filtro prezzo min
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        // Filtro prezzo max
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Filtro anno min
        if ($request->filled('year_min')) {
            $query->where('year', '>=', $request->year_min);
        }

        // Filtro anno max
        if ($request->filled('year_max')) {
            $query->where('year', '<=', $request->year_max);
        }

        // Ordinamento
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'year_desc':
                $query->orderBy('year', 'desc');
                break;
            case 'km_asc':
                $query->orderBy('km', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Paginazione: 12 auto per pagina
        $cars = $query->paginate(12)->withQueryString();

        // Dati per i filtri (opzionale, per popolare dinamicamente i select)
        $brands = Brand::orderBy('name')->get();
        $carTypes = CarType::orderBy('name')->get();
        $fuelTypes = FuelType::orderBy('name')->get();

        return view('inventory', compact('cars', 'brands', 'carTypes', 'fuelTypes'));
    }
}