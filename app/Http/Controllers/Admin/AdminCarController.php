<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use App\Models\FuelType;
use App\Models\Transmission;
use App\Models\CarType;
use App\Models\CarImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class AdminCarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with('brand');

        // Ricerca generale
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

        // Filtro condizione
        if ($request->filled('condition')) {
            $query->where('car_condition', $request->condition);
        }

        // Filtro evidenza
        if ($request->filled('highlighted')) {
            $query->where('highlighted', $request->highlighted);
        }

        // Ordinamento
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        $cars = $query->get();

        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        $brands        = Brand::orderBy('name')->get();
        $carTypes      = CarType::orderBy('name')->get();
        $fuelTypes     = FuelType::orderBy('name')->get();
        $transmissions = Transmission::orderBy('name')->get();

        return view('admin.cars.create', compact('brands', 'carTypes', 'fuelTypes', 'transmissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id'        => 'required|integer|exists:brands,id',
            'model'           => 'required|string|max:100',
            'car_type_id'     => 'required|integer|exists:car_types,id',
            'fuel_type_id'    => 'required|integer|exists:fuel_types,id',
            'transmission_id' => 'required|integer|exists:transmissions,id',
            'year'            => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'price'           => 'required|numeric|min:0',
            'km'              => 'required|integer|min:0',
            'seats'           => 'nullable|integer|min:1|max:9',
            'power_kw'        => 'nullable|integer|min:0',
            'car_condition'   => 'required|in:nuovo,usato',
            'description'     => 'nullable|string',
            'highlighted'     => 'sometimes|boolean',
        ]);

        $validated['highlighted'] = $request->boolean('highlighted');
        $brand = Brand::find($validated['brand_id']);
        $validated['slug'] = Str::slug($brand->name . '-' . $validated['model'] . '-' . $validated['year']);

        // ✅ Crea l’auto
        $car = Car::create($validated);

        // ✅ Se sono presenti immagini temporanee → spostale
        $tempImages = $request->input('temp_images', []);
        $this->moveTempImagesToCar($tempImages, $car);

        return redirect()->route('admin.cars.edit', $car->id)
            ->with('success', 'Auto creata con successo e immagini collegate!');
    }

    public function edit($id)
    {
        $car           = Car::with('images')->findOrFail($id);
        $brands        = Brand::orderBy('name')->get();
        $carTypes      = CarType::orderBy('name')->get();
        $fuelTypes     = FuelType::orderBy('name')->get();
        $transmissions = Transmission::orderBy('name')->get();

        return view('admin.cars.edit', compact('car', 'brands', 'carTypes', 'fuelTypes', 'transmissions'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'brand_id'        => 'required|integer|exists:brands,id',
            'model'           => 'required|string|max:100',
            'car_type_id'     => 'required|integer|exists:car_types,id',
            'fuel_type_id'    => 'required|integer|exists:fuel_types,id',
            'transmission_id' => 'required|integer|exists:transmissions,id',
            'year'            => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'price'           => 'required|numeric|min:0',
            'km'              => 'required|integer|min:0',
            'seats'           => 'nullable|integer|min:1|max:9',
            'power_kw'        => 'nullable|integer|min:0',
            'car_condition'   => 'required|in:nuovo,usato',
            'description'     => 'nullable|string',
            'highlighted'     => 'sometimes|boolean',
        ]);

        $validated['highlighted'] = $request->boolean('highlighted');

        $brand = Brand::find($validated['brand_id']);
        if (
            $car->brand_id != $validated['brand_id'] ||
            $car->model    != $validated['model'] ||
            $car->year     != $validated['year']
        ) {
            $validated['slug'] = Str::slug($brand->name . '-' . $validated['model'] . '-' . $validated['year']);
        }

        $car->update($validated);

        // ✅ Se sono presenti nuove immagini temp → spostale
        $tempImages = $request->input('temp_images', []);
        $this->moveTempImagesToCar($tempImages, $car);

        return redirect()->route('admin.cars.edit', $car->id)
            ->with('success', 'Dati aggiornati con successo!');
    }

    /**
     * ✅ Upload asincrono Dropzone
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file'   => 'required|image|mimes:jpeg,png,webp,jpg,gif|max:8192',
            'car_id' => 'nullable|integer|exists:cars,id',
        ]);

        $carId = $request->input('car_id');
        $manager = new ImageManager(new Driver());
        $file    = $request->file('file');
        $filename = uniqid('car_', true) . '.webp';

        // ✅ Salviamo i file in storage/app/public/temp o storage/app/public/cars/{id}
        $folder = $carId ? storage_path("app/public/cars/{$carId}") : storage_path('app/public/temp');
        if (!is_dir($folder)) mkdir($folder, 0775, true);

        $filepath = $folder . '/' . $filename;

        try {
            $image = $manager->read($file->getRealPath())
                ->encode(new \Intervention\Image\Encoders\WebpEncoder(quality: 80));
            $image->save($filepath);

            // se già collegato a un’auto → crea subito il record DB
            if ($carId) {
                CarImage::create([
                    'car_id'     => $carId,
                    'image_path' => "cars/{$carId}/{$filename}",
                ]);
            }

            return response()->json(['filename' => $filename]);
        } catch (\Exception $e) {
            \Log::error('Errore upload Dropzone: ' . $e->getMessage());
            return response()->json(['error' => 'Errore durante il caricamento'], 500);
        }
    }

    /**
     * ✅ Sposta le immagini da storage/app/public/temp a storage/app/public/cars/{id}
     */
    private function moveTempImagesToCar(array $tempImages, Car $car): void
    {
        if (empty($tempImages)) return;

        $carFolder = storage_path("app/public/cars/{$car->id}");
        $tempFolder = storage_path('app/public/temp');

        if (!is_dir($carFolder)) mkdir($carFolder, 0775, true);

        foreach ($tempImages as $filename) {
            $src = $tempFolder . '/' . basename($filename);
            $dest = $carFolder . '/' . basename($filename);

            if (!file_exists($src)) {
                \Log::warning("⚠️ File temp non trovato: $src");
                continue;
            }

            @rename($src, $dest);

            CarImage::create([
                'car_id'     => $car->id,
                'image_path' => "cars/{$car->id}/" . basename($filename),
            ]);
        }
    }

    /**
     * ✅ Elimina una singola immagine
     */
    public function deleteImage(Request $request, $id)
    {
        $image = CarImage::find($id);
        if (!$image) return response()->json(['error' => 'Immagine non trovata'], 404);

        $path = storage_path('app/public/' . $image->image_path);
        if (file_exists($path)) @unlink($path);

        $image->delete();
        return response()->json(['status' => 'ok']);
    }

    /**
     * ✅ Elimina completamente un’auto
     */
    public function destroy($id)
    {
        $car = Car::with('images')->findOrFail($id);

        foreach ($car->images as $image) {
            $path = storage_path('app/public/' . $image->image_path);
            if (file_exists($path)) @unlink($path);
        }

        $dir = storage_path("app/public/cars/{$car->id}");
        if (is_dir($dir)) {
            @array_map('unlink', glob("$dir/*.*"));
            @rmdir($dir);
        }

        $car->images()->delete();
        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Auto e relative immagini eliminate con successo.');
    }
    /**
     * ✅ Riordina le immagini via AJAX
     */
    public function reorderImages(Request $request)
    {
        $order = $request->input('order'); // array di ID in nuovo ordine
        if (!$order || !is_array($order)) {
            return response()->json(['error' => 'Ordine non valido'], 400);
        }

        foreach ($order as $position => $id) {
            \App\Models\CarImage::where('id', $id)->update(['position' => $position]);
        }

        return response()->json(['status' => 'ok']);
    }

}