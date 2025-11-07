@php
$businessData = [
    '@context' => 'https://schema.org',
    '@type' => 'AutoDealer',
    '@id' => url('/') . '#autodealer',
    'name' => 'AMC S.R.L.S. Auto Showroom',
    'url' => url('/'),
    'inLanguage' => 'it-IT',
    'logo' => asset('favicon.ico'),
    'image' => asset('favicon.ico'),
    'description' => 'AMC SRLS è una concessionaria d’auto online che offre veicoli selezionati, assistenza e servizi personalizzati in tutta Italia.',
    'email' => 'info@amc-srls.it',
    'priceRange' => '€€',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Italia',
        'addressCountry' => 'IT',
    ],
    'openingHours' => 'Mo-Fr 09:00-18:00',
];
@endphp

<script type="application/ld+json">
@json($businessData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
</script>
