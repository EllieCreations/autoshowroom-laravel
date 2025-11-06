<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('emails.contact');
    }

    public function send(Request $request)
    {
        // Validazione base
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string',
            'message' => 'required|string|max:2000',
            'recaptcha_token' => 'required',
        ], [
            'name.required' => 'Il nome è obbligatorio',
            'email.required' => 'L\'email è obbligatoria',
            'email.email' => 'Inserisci un\'email valida',
            'message.required' => 'Il messaggio è obbligatorio',
            'recaptcha_token.required' => 'Verifica reCAPTCHA fallita',
        ]);

        // Verifica reCAPTCHA
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->recaptcha_token,
            'remoteip' => $request->ip(),
        ]);

        $recaptchaData = $recaptchaResponse->json();

        // Controlla se reCAPTCHA è valido e ha uno score accettabile
        if (!$recaptchaData['success'] || $recaptchaData['score'] < 0.5) {
            \Log::warning('reCAPTCHA fallito', [
                'score' => $recaptchaData['score'] ?? 0,
                'ip' => $request->ip()
            ]);
            
            return back()->with('error', '❌ Verifica antispam fallita. Riprova.');
        }

        try {
            // Log dello score per monitoraggio
            \Log::info('reCAPTCHA score', ['score' => $recaptchaData['score']]);
            
            // Invia email
            Mail::to('info@amc-srls.it')
                ->send(new ContactFormMail($validated));

            return back()->with('success', '✅ Messaggio inviato con successo! Ti contatteremo presto.');
            
        } catch (\Exception $e) {
            \Log::error('Errore invio email: ' . $e->getMessage());
            
            return back()->with('error', '❌ Errore nell\'invio. Riprova più tardi.');
        }
    }
}