<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Mail\ContactConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact'); // Questa è la PAGINA WEB del form (contact.blade.php)
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
            'car_id' => 'nullable|exists:cars,id',
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
            
            // Recupera info auto se presente
            $car = null;
            if (!empty($validated['car_id'])) {
                $car = \App\Models\Car::with(['brand', 'images'])->find($validated['car_id']);
            }
            
            // 1. Invia email A TE (info@amc-srls.it) con i dati del form
            //    Usa ContactFormMail che punta a emails.contact-notification
            Mail::to('info@amc-srls.it')
                ->send(new ContactFormMail($validated, $car)); 

            // 2. Invia email di CONFERMA al CLIENTE
            //    Usa ContactConfirmationMail che punta a emails.contact-confirmation
            Mail::to($validated['email'])
                ->send(new ContactConfirmationMail($validated, $car)); 

            return back()->with('success', '✅ Messaggio inviato con successo! Ti contatteremo presto.');
            
        } catch (\Exception $e) {
            \Log::error('Errore invio email: ' . $e->getMessage());
            
            return back()->with('error', '❌ Errore nell\'invio. Riprova più tardi.');
        }
    }
}