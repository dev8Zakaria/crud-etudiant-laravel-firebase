<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('etudiants.index');
        }
        
        return view('dashboard', [
            'etudiant' => $user->etudiant
        ]);
    }
}