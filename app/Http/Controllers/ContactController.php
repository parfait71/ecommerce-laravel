<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Envoi de l'email
        try {
            Mail::raw(
                "Message de contact reçu depuis EazyStore :\n\n" .
                "Nom : {$validated['name']}\n" .
                "Email : {$validated['email']}\n" .
                "Message :\n{$validated['message']}",
                function ($mail) use ($validated) {
                    $mail->to('gnaweparfait1@gmail.com')
                        ->subject('Nouveau message de contact EazyStore')
                        ->replyTo($validated['email'], $validated['name']);
                }
            );
            return back()->with('success', 'Votre message a bien été envoyé. Merci de nous avoir contactés !');
        } catch (\Exception $e) {
            Log::error('Erreur envoi contact: ' . $e->getMessage());
            return back()->with('error', "Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer plus tard.");
        }
    }
} 