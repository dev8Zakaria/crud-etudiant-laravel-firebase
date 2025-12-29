<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Etudiant;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Exception\Auth\InvalidPassword;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\Auth\EmailExists;

class AuthController extends Controller
{
    protected $auth;

    public function __construct()
    {
        $this->auth = Firebase::auth();
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // 1. Tenter la connexion chez Firebase
            $signInResult = $this->auth->signInWithEmailAndPassword($credentials['email'], $credentials['password']);
            
            // 2. Si Firebase valide, on cherche l'utilisateur local
            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                // L'utilisateur existe chez Firebase mais pas en local (Cas rare mais possible)
                // On pourrait le créer ici, mais pour l'instant on bloque.
                return back()->withErrors(['email' => "Compte local introuvable pour cet utilisateur Firebase."]);
            }

            // 3. Connexion locale Laravel (SANS vérification de mot de passe SQL)
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');

        } catch (UserNotFound $e) {
            // SCÉNARIO MIGRATION : L'utilisateur existe peut-être en local mais pas encore sur Firebase
            // On vérifie si c'est un "vieux" compte MySQL qui essaie de se connecter
            $localUser = User::where('email', $credentials['email'])->first();

            if ($localUser && Hash::check($credentials['password'], $localUser->password)) {
                // C'est le bon mot de passe local ! On migre l'utilisateur vers Firebase
                try {
                    $this->auth->createUser([
                        'email' => $localUser->email,
                        'password' => $credentials['password'],
                        'displayName' => $localUser->name,
                        'emailVerified' => true,
                    ]);
                    
                    // On connecte
                    Auth::login($localUser, $request->filled('remember'));
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                    
                } catch (\Exception $ex) {
                    return back()->withErrors(['email' => "Erreur lors de la migration vers Firebase: " . $ex->getMessage()]);
                }
            }

            return back()->withErrors(['email' => "Aucun compte trouvé (Firebase & Local)."]);

        } catch (InvalidPassword $e) {
            return back()->withErrors(['password' => "Mot de passe incorrect."]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => "Erreur d'authentification : " . $e->getMessage()]);
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // On vérifie l'unicité locale aussi
            'password' => 'required|string|min:8|confirmed',
            'numero_apogee' => 'required|string|unique:etudiants',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // 1. Création du compte sur Firebase Auth
            $firebaseUser = $this->auth->createUser([
                'email' => $validated['email'],
                'password' => $validated['password'],
                'displayName' => $validated['name'],
                'emailVerified' => false,
            ]);

            // 2. Création du compte Local (MySQL) 
            // On stocke un mot de passe aléatoire en base car c'est Firebase qui gère l'auth maintenant
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(32)), // Mot de passe "poubelle" sécurisé
                'role' => 'etudiant',
            ]);

            // Gérer l'upload de la photo
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
            }

            // Créer l'étudiant
            Etudiant::create([
                'numero_apogee' => $validated['numero_apogee'],
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'],
                'photo' => $photoPath,
                'user_id' => $user->id,
            ]);

            Auth::login($user);

            return redirect('/dashboard')->with('success', 'Inscription réussie via Firebase !');

        } catch (EmailExists $e) {
            return back()->withErrors(['email' => "Cet email est déjà inscrit sur Firebase."]);
        } catch (\Exception $e) {
            // En cas d'erreur, on pourrait vouloir annuler la création Firebase si elle a réussi...
            return back()->withErrors(['email' => "Erreur technique : " . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}