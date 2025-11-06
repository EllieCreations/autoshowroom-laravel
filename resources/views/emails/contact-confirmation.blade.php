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
            <h1>✅ Messaggio Ricevuto!</h1>
        </div>
        <div class="content">
            <p>Gentile <strong>{{ $data['name'] }}</strong>,</p>
            <p>Grazie per averci contattato! Abbiamo ricevuto il tuo messaggio e ti risponderemo il prima possibile.</p>
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