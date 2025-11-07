<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: white; padding: 30px; border: 1px solid #e5e7eb; }
        .field { margin-bottom: 15px; padding: 12px; background: #f9fafb; border-radius: 6px; border-left: 3px solid #3b82f6; }
        .label { font-weight: bold; color: #374151; font-size: 13px; text-transform: uppercase; margin-bottom: 5px; }
        .value { color: #1f2937; margin-top: 5px; font-size: 15px; }
        .message-field { background: #fff7ed; border-left: 3px solid #f59e0b; }
        .footer { background: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Nuovo Messaggio di Contatto</h1>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Ricevuto da AMC-SRLS Auto Showroom</p>
        </div>
        
        <div class="content">
            <div class="field">
                <div class="label">👤 Nome Completo</div>
                <div class="value">{{ $data['name'] }}</div>
            </div>

            <div class="field">
                <div class="label">📧 Indirizzo Email</div>
                <div class="value"><a href="mailto:{{ $data['email'] }}" style="color: #3b82f6; text-decoration: none;">{{ $data['email'] }}</a></div>
            </div>

            @if(!empty($data['phone']))
            <div class="field">
                <div class="label">📱 Numero di Telefono</div>
                <div class="value"><a href="tel:{{ $data['phone'] }}" style="color: #3b82f6; text-decoration: none;">{{ $data['phone'] }}</a></div>
            </div>
            @endif

            @if(!empty($data['subject']))
            <div class="field">
                <div class="label">📋 Oggetto della Richiesta</div>
                <div class="value">
                    @switch($data['subject'])
                        @case('info')
                            Richiesta informazioni
                            @break
                        @case('test_drive')
                            Prenotazione test drive
                            @break
                        @case('valutazione')
                            Valutazione auto usata
                            @break
                        @case('finanziamento')
                            Finanziamento
                            @break
                        @default
                            Altro
                    @endswitch
                </div>
            </div>
            @endif

            {{-- Sezione Auto --}}
            @if($car)
            <div class="field" style="background: #dbeafe; border-left: 3px solid #2563eb;">
                <div class="label">🚗 AUTO DI INTERESSE</div>
                <div class="value">
                    <strong style="font-size: 16px; color: #1e40af;">
                        {{ $car->brand->name ?? 'Auto' }} {{ $car->model }}
                    </strong>
                    <div style="margin-top: 8px; font-size: 14px; color: #475569;">
                        📅 Anno: {{ $car->year }} | 
                        🛣️ Km: {{ number_format($car->km, 0, ',', '.') }} km | 
                        💰 Prezzo: <strong style="color: #2563eb;">€ {{ number_format($car->price, 0, ',', '.') }}</strong>
                    </div>
                    <div style="margin-top: 12px;">
                        <a href="{{ url('/admin/cars/' . $car->id . '/edit') }}" 
                           style="display: inline-block; background: #2563eb; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-size: 13px; margin-right: 8px;">
                            📝 Vedi in Admin
                        </a>
                        <a href="{{ url('/cars/' . $car->id) }}" 
                           style="display: inline-block; background: #059669; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; font-size: 13px;">
                            👁️ Vedi sul Sito
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <div class="field message-field">
                <div class="label">💬 Messaggio del Cliente</div>
                <div class="value" style="white-space: pre-line; line-height: 1.8;">{{ $data['message'] }}</div>
            </div>

            <div style="margin-top: 20px; padding: 15px; background: #e0f2fe; border-radius: 6px; border-left: 3px solid #0284c7;">
                <p style="margin: 0; font-size: 14px; color: #075985;">
                    <strong>💡 Azione richiesta:</strong> Rispondi al cliente entro 24-48 ore lavorative.
                </p>
            </div>
        </div>
        
        <div class="footer">
            <p style="margin: 5px 0;">📅 Ricevuto il <strong>{{ date('d/m/Y') }}</strong> alle <strong>{{ date('H:i') }}</strong></p>
            <p style="margin: 5px 0; color: #9ca3af;">Questo messaggio è stato inviato dal form di contatto su amc-srls.it</p>
        </div>
    </div>
</body>
</html>