<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Illuminate\Support\Facades\Log;
use App\Models\User;

use Illuminate\Support\Facades\Mail; // Ajout de l'import Mail

class FirebaseAuthController extends Controller
{
    protected $auth;

    public function __construct()
    {
        $this->auth = Firebase::auth();
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        // 1. Vérifier si l'utilisateur existe dans notre base locale MySQL
        $localUser = User::where('email', $email)->first();
        if (!$localUser) {
            return back()->withErrors(['email' => "Nous ne trouvons pas d'utilisateur avec cette adresse e-mail."]);
        }

        try {
            // 2. Tenter de récupérer l'utilisateur Firebase (Sync)
            try {
                $this->auth->getUserByEmail($email);
            } catch (UserNotFound $e) {
                // Création silencieuse si besoin
                $this->auth->createUser([
                    'email' => $email,
                    'emailVerified' => true,
                    'password' => 'Temporaire123!'
                ]);
            }

            // 3. Générer le lien via Firebase
            $link = $this->auth->getPasswordResetLink($email);
            
            // Pour le TP/Démo : On affiche le lien directement car le SMTP local n'est pas fiable.
            // Le style CSS sera géré dans la vue pour éviter que le lien ne déborde.
            return back()->with('firebase_link', $link);

        } catch (\Exception $e) {
            return back()->withErrors(['email' => "Erreur : " . $e->getMessage()]);
        }
    }
}
