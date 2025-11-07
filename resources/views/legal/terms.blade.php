@extends('layouts.app')

@section('title', 'Termini e Condizioni | AMC SRLS Auto Showroom')
@section('meta_description', 'Consulta i termini d’uso del sito AMC SRLS Auto Showroom. Informazioni legali, responsabilità e proprietà dei contenuti.')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 text-gray-700 py-20">
  <div class="max-w-5xl mx-auto px-6 md:px-10">
    <div class="text-center mb-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-3">Termini e Condizioni d’Uso</h1>
      <p class="text-gray-500 text-lg">Ultimo aggiornamento: {{ date('d/m/Y', filemtime(resource_path('views/legal/privacy.blade.php'))) }} </p>
    </div>

    <div class="space-y-8 leading-relaxed">
      <p>
        L’accesso e la navigazione sul sito <strong>amc-srls.it</strong> implicano l’accettazione integrale
        dei presenti termini e condizioni d’uso.
        Si invita pertanto l’utente a leggerli attentamente prima di utilizzare il sito.
      </p>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">1. Titolare del sito</h2>
        <p>
          Il sito è di proprietà di <strong>AMC S.R.L.S.</strong> – P.IVA 12345678901,
          contattabile all’indirizzo email
          <a href="mailto:info@amc-srls.it" class="text-blue-600 hover:underline">info@amc-srls.it</a>.
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">2. Uso consentito del sito</h2>
        <p>
          Tutti i contenuti e le immagini presenti hanno finalità informativa e non costituiscono offerta commerciale vincolante.
          AMC S.R.L.S. si riserva il diritto di modificare o aggiornare in qualsiasi momento le informazioni pubblicate.
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">3. Proprietà intellettuale</h2>
        <p>
          Testi, immagini e loghi sono di esclusiva proprietà di AMC S.R.L.S.
          È vietata la copia o la diffusione, anche parziale, senza consenso scritto.
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">4. Limitazione di responsabilità</h2>
        <p>
          AMC S.R.L.S. non risponde di eventuali danni diretti o indiretti derivanti
          dall’uso delle informazioni o dall’impossibilità di accesso al sito.
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">5. Legge applicabile</h2>
        <p>
          I presenti termini sono disciplinati dalla legge italiana.
          Qualsiasi controversia sarà di competenza esclusiva del Foro di Milano.
        </p>
      </div>
    </div>
  </div>
</section>
@endsection
