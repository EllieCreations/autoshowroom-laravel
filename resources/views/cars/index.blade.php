@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-4">Auto disponibili</h1>

  <div class="grid grid-cols-3 gap-6">
    @foreach($cars as $car)
      <div class="bg-white shadow rounded-lg p-3">
        <img src="{{ $car->images->first()->image_path ?? '' }}" class="rounded mb-2">
        <h2 class="font-semibold">{{ $car->brand->name ?? 'Senza marca' }}</h2>
        <p class="text-gray-600">Anno: {{ $car->year }}</p>
        <p class="text-brand-gold">€ {{ number_format($car->price, 2, ',', '.') }}</p>
      </div>
    @endforeach
  </div>
@endsection
