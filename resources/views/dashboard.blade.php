@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('styles')
<style>
    .welcome-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border-radius: 24px;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 3rem;
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        right: -50px;
        top: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-card h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .welcome-card p {
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    .stat-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon-wrapper.blue { background: rgba(99, 102, 241, 0.1); color: var(--primary); }
    .stat-icon-wrapper.purple { background: rgba(168, 85, 247, 0.1); color: var(--secondary); }
    .stat-icon-wrapper.rose { background: rgba(244, 63, 94, 0.1); color: var(--accent); }

    .stat-info span {
        display: block;
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-info h3 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .profile-section {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 2rem;
    }

    .profile-card-inner {
        text-align: center;
    }

    .profile-photo-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
    }

    .profile-photo, .profile-placeholder-large {
        width: 100%;
        height: 100%;
        border-radius: 30px;
        object-fit: cover;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .profile-placeholder-large {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: 800;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .detail-item:last-child { border-bottom: none; }

    .detail-label {
        font-weight: 600;
        color: var(--text-muted);
    }

    .detail-value {
        font-weight: 700;
        color: var(--text-main);
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-btn {
        background: #f8fafc;
        border: 2px solid transparent;
        padding: 1.5rem;
        border-radius: 16px;
        text-align: center;
        text-decoration: none;
        color: var(--text-main);
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .action-btn:hover {
        background: white;
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-3px);
        box-shadow: var(--shadow);
    }

    .action-btn i { width: 24px; height: 24px; }

    @media (max-width: 768px) {
        .profile-section { grid-template-columns: 1fr; }
        .welcome-card { padding: 2rem; }
        .welcome-card h1 { font-size: 1.75rem; }
    }
</style>
@endsection

@section('content')
<div class="welcome-card">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
        <i data-lucide="sparkles" style="width: 32px; height: 32px;"></i>
        <span style="font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.875rem;">Platforme de Gestion</span>
    </div>
    <h1>Bonjour, {{ auth()->user()->name }} !</h1>
    <p>
        {{ auth()->user()->isAdmin() ? 'Accès Administrateur • Gérer l\'institution en toute simplicité.' : 'Espace Étudiant • Consultez vos informations personnelles.' }}
    </p>
</div>

@if(auth()->user()->isAdmin())
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper blue">
                <i data-lucide="users"></i>
            </div>
            <div class="stat-info">
                <span>Total Étudiants</span>
                <h3>{{ \App\Models\Etudiant::count() }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrapper purple">
                <i data-lucide="shield-check"></i>
            </div>
            <div class="stat-info">
                <span>Comptes Actifs</span>
                <h3>{{ \App\Models\User::where('role', 'etudiant')->count() }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrapper rose">
                <i data-lucide="user-plus"></i>
            </div>
            <div class="stat-info">
                <span>Nouveaux ce mois</span>
                <h3>{{ \App\Models\Etudiant::whereMonth('created_at', now()->month)->count() }}</h3>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <i data-lucide="zap" style="color: var(--primary);"></i>
            Actions Rapides
        </h2>
        <div class="quick-actions-grid">
            <a href="{{ route('etudiants.index') }}" class="action-btn">
                <i data-lucide="list"></i>
                <span class="font-bold">Liste Complète</span>
            </a>
            <a href="{{ route('etudiants.create') }}" class="action-btn">
                <i data-lucide="user-plus"></i>
                <span class="font-bold">Nouveau Profil</span>
            </a>
            <a href="#" class="action-btn">
                <i data-lucide="file-text"></i>
                <span class="font-bold">Rapports PDF</span>
            </a>
            <a href="#" class="action-btn">
                <i data-lucide="settings"></i>
                <span class="font-bold">Paramètres</span>
            </a>
        </div>
    </div>
@else
    @if($etudiant)
    <div class="profile-section">
        <div class="card profile-card-inner">
            <div class="profile-photo-container">
                @if($etudiant->photo)
                    <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="Photo" class="profile-photo">
                @else
                    <div class="profile-placeholder-large">
                        {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h2 style="margin-bottom: 0.25rem;">{{ $etudiant->prenom }} {{ $etudiant->nom }}</h2>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Étudiant • {{ $etudiant->numero_apogee }}</p>
            <a href="#" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i data-lucide="edit-3"></i>
                Modifier Profil
            </a>
        </div>

        <div class="card">
            <h2 style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <i data-lucide="info" style="color: var(--primary);"></i>
                Informations Détaillées
            </h2>
            <div class="detail-item">
                <span class="detail-label">Numéro d'Apogée</span>
                <span class="detail-value">{{ $etudiant->numero_apogee }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email Personnel</span>
                <span class="detail-value">{{ $etudiant->email }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Téléphone</span>
                <span class="detail-value">{{ $etudiant->telephone }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Date d'inscription</span>
                <span class="detail-value">{{ $etudiant->created_at->format('d F Y') }}</span>
            </div>
        </div>
    </div>
    @endif
@endif
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
