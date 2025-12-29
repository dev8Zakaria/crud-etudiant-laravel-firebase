@extends('layouts.app')

@section('title', 'Profil de ' . $etudiant->prenom)

@section('styles')
<style>
    .profile-header {
        background: white;
        border-radius: 32px;
        padding: 3rem;
        box-shadow: var(--shadow);
        display: flex;
        gap: 3rem;
        align-items: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(168, 85, 247, 0.05) 100%);
        clip-path: polygon(20% 0%, 100% 0%, 100% 100%, 0% 100%);
        z-index: 0;
    }

    .profile-avatar-wrapper {
        position: relative;
        z-index: 1;
    }

    .profile-avatar {
        width: 180px;
        height: 180px;
        border-radius: 40px;
        object-fit: cover;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border: 8px solid white;
    }

    .profile-placeholder {
        width: 180px;
        height: 180px;
        border-radius: 40px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
        font-weight: 800;
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
        border: 8px solid white;
    }

    .profile-info-main {
        flex: 1;
        z-index: 1;
    }

    .profile-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary);
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .info-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: var(--shadow);
    }

    .info-card-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.125rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        color: var(--text-main);
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info-item:last-child { border-bottom: none; }

    .info-label {
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 600;
    }

    .info-value {
        color: var(--text-main);
        font-weight: 700;
        text-align: right;
    }

    @media (max-width: 1024px) {
        .profile-header { flex-direction: column; text-align: center; padding: 2rem; }
        .profile-grid { grid-template-columns: 1fr; }
        .info-item { flex-direction: column; align-items: center; text-align: center; gap: 0.25rem; }
        .info-value { text-align: center; }
    }
</style>
@endsection

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">
        <a href="{{ route('etudiants.index') }}" style="color: inherit; text-decoration: none;">Étudiants</a>
        <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
        <span style="color: var(--primary); font-weight: 600;">Profil Étudiant</span>
    </div>
    
    <div style="display: flex; gap: 0.75rem;">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('etudiants.edit', $etudiant) }}" class="btn" style="background: white; color: var(--text-main);">
                <i data-lucide="edit-3"></i>
                Modifier
            </a>
        @endif
        <a href="{{ route('etudiants.index') }}" class="btn btn-primary">
            <i data-lucide="arrow-left"></i>
            Retour
        </a>
    </div>
</div>

<div class="profile-header">
    <div class="profile-avatar-wrapper">
        @if($etudiant->photo)
            <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="Photo" class="profile-avatar">
        @else
            <div class="profile-placeholder">
                {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
            </div>
        @endif
    </div>

    <div class="profile-info-main">
        <div class="profile-role-badge">
            <i data-lucide="graduation-cap" style="width: 18px; height: 18px;"></i>
            Étudiant Régulier
        </div>
        <h1 style="font-size: 2.5rem; font-weight: 900; color: var(--text-main); margin-bottom: 0.5rem;">
            {{ $etudiant->prenom }} {{ $etudiant->nom }}
        </h1>
        <p style="color: var(--text-muted); font-size: 1.125rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="hash" style="width: 18px; height: 18px;"></i>
            Apogée: <strong>{{ $etudiant->numero_apogee }}</strong>
        </p>
    </div>
</div>

<div class="profile-grid">
    <div class="info-card">
        <div class="info-card-title">
            <i data-lucide="user" style="color: var(--primary);"></i>
            Détails Personnels
        </div>
        <div class="info-item">
            <div class="info-label">Nom Complet</div>
            <div class="info-value">{{ $etudiant->nom }} {{ $etudiant->prenom }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Email Institutionnel</div>
            <div class="info-value">{{ $etudiant->email }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Téléphone</div>
            <div class="info-value">{{ $etudiant->telephone }}</div>
        </div>
    </div>

    <div class="info-card">
        <div class="info-card-title">
            <i data-lucide="shield" style="color: var(--secondary);"></i>
            Compte & Sécurité
        </div>
        <div class="info-item">
            <div class="info-label">Nom d'utilisateur</div>
            <div class="info-value">@ {{ $etudiant->user->name }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Statut du Compte</div>
            <div class="info-value">
                <span style="color: #10b981; display: inline-flex; align-items: center; gap: 0.25rem;">
                    <i data-lucide="check-circle" style="width: 14px; height: 14px;"></i>
                    Vérifié
                </span>
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Membre depuis</div>
            <div class="info-value">{{ $etudiant->created_at->format('M Y') }}</div>
        </div>
    </div>
</div>

<div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
    <div class="info-card" style="display: flex; align-items: center; gap: 1.5rem; padding: 1.5rem;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="calendar"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">DERNIÈRE MISE À JOUR</div>
            <div style="font-weight: 800; color: var(--text-main);">{{ $etudiant->updated_at->diffForHumans() }}</div>
        </div>
    </div>
    
    <div class="info-card" style="display: flex; align-items: center; gap: 1.5rem; padding: 1.5rem;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="clock"></i>
        </div>
        <div>
            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">DATE D'INSCRIPTION</div>
            <div style="font-weight: 800; color: var(--text-main);">{{ $etudiant->created_at->format('d/m/Y') }}</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
