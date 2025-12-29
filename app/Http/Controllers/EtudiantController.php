<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EtudiantController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $etudiants = Etudiant::with('user')->paginate(10);
        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('etudiants.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'numero_apogee' => 'required|string|unique:etudiants',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'etudiant',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Etudiant::create([
            'numero_apogee' => $validated['numero_apogee'],
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'photo' => $photoPath,
            'user_id' => $user->id,
        ]);

        return redirect()->route('etudiants.index')->with('success', 'Étudiant créé avec succès !');
    }

    public function show(Etudiant $etudiant)
    {
        if (!auth()->user()->isAdmin() && auth()->user()->id !== $etudiant->user_id) {
            abort(403);
        }

        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'numero_apogee' => 'required|string|unique:etudiants,numero_apogee,' . $etudiant->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:etudiants,email,' . $etudiant->id,
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($etudiant->photo) {
                Storage::disk('public')->delete($etudiant->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $etudiant->update($validated);

        return redirect()->route('etudiants.index')->with('success', 'Étudiant modifié avec succès !');
    }

    public function destroy(Etudiant $etudiant)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($etudiant->photo) {
            Storage::disk('public')->delete($etudiant->photo);
        }

        $user = $etudiant->user;
        $etudiant->delete();
        $user->delete();

        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé avec succès !');
    }
}