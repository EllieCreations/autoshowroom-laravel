@extends('layouts.app')

@section('title', 'Privacy Policy | AMC SRLS Auto Showroom')
@section('meta_description', 'Scopri come AMC SRLS tratta i tuoi dati personali in conformità al GDPR. Informativa completa su finalità, tempi di conservazione e diritti degli utenti.')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 text-gray-700 py-20">
  <div class="max-w-5xl mx-auto px-6 md:px-10">
    <div class="text-center mb-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-3">Informativa sulla Privacy</h1>
      <p class="text-gray-500 text-lg">Ai sensi dell’art. 13 del Regolamento (UE) 2016/679 (GDPR)</p>
    </div>

    <div class="space-y-8 leading-relaxed">
      <p>
        La presente informativa descrive le modalità di trattamento dei dati personali
        raccolti tramite il sito <strong>amc-srls.it</strong>.
        Il trattamento avviene nel pieno rispetto del Regolamento (UE) 2016/679 e della normativa italiana vigente.
      </p>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Titolare del trattamento</h2>
        <p>
          AMC S.R.L.S. – P.IVA 12345678901<br>
          Email: <a href="mailto:info@amc-srls.it" class="text-blue-600 hover:underline">info@amc-srls.it</a>
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Finalità e base giuridica del trattamento</h2>
        <p>
          I dati forniti attraverso il modulo contatti vengono trattati esclusivamente per rispondere
          alle richieste inviate e non saranno comunicati a terzi.
          La base giuridica è il consenso espresso dall’utente.
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Modalità di trattamento e conservazione</h2>
        <p>
          Il trattamento avviene con strumenti informatici e digitali, adottando misure di sicurezza idonee
          a proteggere i dati da accessi non autorizzati.
          I dati saranno conservati per il tempo necessario a evadere la richiesta e comunque non oltre 12 mesi.
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Diritti dell’interessato</h2>
        <p>
          L’utente può esercitare i diritti previsti dagli articoli 15–22 del GDPR
          (accesso, rettifica, cancellazione, limitazione, opposizione e portabilità)
          scrivendo a <a href="mailto:info@amc-srls.it" class="text-blue-600 hover:underline">info@amc-srls.it</a>.
        </p>
      </div>

      <div>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Cookie e strumenti di terze parti</h2>
        <p>
          Il sito utilizza esclusivamente cookie tecnici necessari al suo funzionamento.
          Se in futuro verranno implementati cookie di profilazione o analytics di terze parti,
          sarà mostrato un apposito banner per la raccolta del consenso.
        </p>
      </div>

      <p class="text-sm text-gray-500 mt-12 text-center">
        Ultimo aggiornamento: {{ date('d/m/Y', filemtime(resource_path('views/legal/privacy.blade.php'))) }}
      </p>
    </div>
  </div>
</section>
@endsection
