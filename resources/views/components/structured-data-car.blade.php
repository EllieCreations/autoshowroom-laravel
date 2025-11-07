@php
$carData = [
    '@context' => 'https://schema.org',
    '@type' => 'Vehicle',
    '@id' => url()->current() . '#car',
    'name' => $car->brand->name . ' ' . $car->model,
    'brand' => $car->brand->name,
    'model' => $car->model,
    'image' => asset('storage/' . $car->images->first()->path),
    'url' => url()->current(),
    'vehicleEngine' => [
        '@type' => 'EngineSpecification',
        'enginePower' => [
            '@type' => 'QuantitativeValue',
            'value' => $car->power_kw,
            'unitCode' => 'KWT',
        ],
    ],
    'fuelType' => $car->fuelType->name ?? 'Benzina',
    'vehicleTransmission' => $car->transmission->name ?? 'Manuale',
    'bodyType' => $car->body_type ?? null,
    'color' => $car->color ?? null,
    'numberOfDoors' => $car->doors ?? null,
    'mileageFromOdometer' => [
        '@type' => 'QuantitativeValue',
        'value' => $car->km,
        'unitCode' => 'KMT',
    ],
    'modelDate' => $car->year,
    'itemCondition' => $car->car_condition === 'nuovo'
        ? 'https://schema.org/NewCondition'
        : 'https://schema.org/UsedCondition',
    'offers' => [
        '@type' => 'Offer',
        'priceCurrency' => 'EUR',
        'price' => $car->price,
        'availability' => match($car->status ?? 'in_stock') {
            'sold' => 'https://schema.org/SoldOut',
            'reserved' => 'https://schema.org/PreOrder',
            default => 'https://schema.org/InStock',
        },
        'url' => url()->current(),
    ],
    'seller' => [
        '@type' => 'AutoDealer',
        '@id' => url('/') . '#autodealer',
        'name' => 'AMC S.R.L.S. Auto Showroom',
    ],
];

// Aggiungi immagini se presenti
if ($car->images->first()) {
    $images = [];
    foreach ($car->images as $image) {
        $images[] = url('storage/' . $image->image_path);
    }
    $carData['image'] = $images;
}

// Aggiungi potenza motore se presente
if (isset($car->power_kw)) {
    $carData['vehicleEngine'] = [
        '@type' => 'EngineSpecification',
        'enginePower' => [
            '@type' => 'QuantitativeValue',
            'value' => $car->power_kw,
            'unitCode' => 'KWT'
        ]
    ];
}
@endphp

<script type="application/ld+json">
@json($carData)
</script>