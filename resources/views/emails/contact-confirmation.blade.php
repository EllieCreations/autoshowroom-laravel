<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: white; padding: 30px; border: 1px solid #e5e7eb; }
        .footer { background: #f9fafb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Messaggio Ricevuto!</h1>
        </div>
        <div class="content">
            <p>Gentile <strong>{{ $data['name'] }}</strong>,</p>
            <p>Grazie per averci contattato! Abbiamo ricevuto il tuo messaggio e ti risponderemo il prima possibile.</p>
            
            {{-- Mostra auto se presente --}}
            @if($car)
            <div style="background: #dbeafe; border-left: 4px solid #2563eb; padding: 20px; margin: 20px 0; border-radius: 6px;">
                <p style="margin: 0 0 10px 0; font-weight: bold; color: #1e40af; font-size: 14px;">🚗 HAI RICHIESTO INFORMAZIONI SU:</p>
                <p style="margin: 0; font-size: 18px; font-weight: bold; color: #1e3a8a;">
                    {{ $car->brand->name ?? 'Auto' }} {{ $car->model }}
                </p>
                <p style="margin: 8px 0; font-size: 14px; color: #475569;">
                    Anno {{ $car->year }} • {{ number_format($car->km, 0, ',', '.') }} km • {{ ucfirst($car->car_condition) }}
                </p>
                <p style="margin: 8px 0; font-size: 22px; font-weight: bold; color: #2563eb;">
                    € {{ number_format($car->price, 0, ',', '.') }}
                </p>
                <a href="{{ url('/cars/' . $car->id) }}" 
                   style="display: inline-block; margin-top: 10px; background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold;">
                    👁️ Vedi Dettagli Auto
                </a>
            </div>
            @endif
            
            <p><strong>Riepilogo del tuo messaggio:</strong></p>
            <p style="background: #f3f4f6; padding: 15px; border-left: 4px solid #3b82f6; white-space: pre-line;">{{ $data['message'] }}</p>
            <p>Il nostro team ti ricontatterà entro 24-48 ore lavorative.</p>
            <p>Cordiali saluti,<br><strong>Il team AMC-SRLS</strong></p>
        </div>
        <div class="footer">
            <p><strong>AMC-SRLS Auto Showroom</strong><br>
            📍 Milano, Italia | 📧 info@amc-srls.it | 📞 +39 XXX XXX XXXX</p>
        </div>
    </div>
</body>
</html>