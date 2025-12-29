@extends('layouts.app')

@section('title', 'Inscription - Gestion Étudiants')

@section('styles')
<style>
    .auth-page {
        min-height: calc(100vh - 4rem);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        width: 100%;
    }

    .auth-card {
        background: white;
        border-radius: 32px;
        width: 100%;
        max-width: 540px;
        padding: 2.5rem;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-logo {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .auth-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 0.25rem;
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-group label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i, .input-wrapper svg {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        width: 16px;
        height: 16px;
        pointer-events: none;
        transition: color 0.2s;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border-radius: 14px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        font-family: inherit;
        font-size: 0.9375rem;
        transition: all 0.2s;
        display: block;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.05);
    }

    .form-control:focus ~ i, 
    .form-control:focus ~ svg {
        color: var(--primary);
    }

    .photo-upload {
        grid-column: span 2;
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .photo-upload:hover {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.02);
    }

    .btn-auth {
        width: 100%;
        padding: 1rem;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border: none;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        margin-top: 1rem;
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }

    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.2);
    }

    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
        font-size: 0.875rem;
    }

    .auth-footer a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
    }

    .error-msg {
        color: var(--accent);
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 0.4rem;
    }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full-width, .photo-upload { grid-column: span 1; }
        .auth-card { padding: 2rem; }
    }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i data-lucide="user-plus" style="width: 28px; height: 28px;"></i>
            </div>
            <h1 class="auth-title">Créer un compte</h1>
            <p class="auth-subtitle">Rejoignez la plateforme étudiante</p>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label>Nom d'utilisateur</label>
                    <div class="input-wrapper">
                        <input type="text" name="name" class="form-control @error('name') error @enderror" value="{{ old('name') }}" required placeholder="ex: jsmith24">
                        <i data-lucide="at-sign"></i>
                    </div>
                    @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group full-width">
                    <label>Email Institutionnel</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" class="form-control @error('email') error @enderror" value="{{ old('email') }}" required placeholder="j.smith@univ.ma">
                        <i data-lucide="mail"></i>
                    </div>
                    @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" class="form-control @error('password') error @enderror" required placeholder="••••••••">
                        <i data-lucide="lock"></i>
                    </div>
                    @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Confirmation</label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
                        <i data-lucide="shield-check"></i>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Numéro d'Apogée</label>
                    <div class="input-wrapper">
                        <input type="text" name="numero_apogee" class="form-control @error('numero_apogee') error @enderror" value="{{ old('numero_apogee') }}" required placeholder="Ex: 22004512">
                        <i data-lucide="hash"></i>
                    </div>
                    @error('numero_apogee') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Nom</label>
                    <div class="input-wrapper">
                        <input type="text" name="nom" class="form-control @error('nom') error @enderror" value="{{ old('nom') }}" required placeholder="Nom">
                        <i data-lucide="user"></i>
                    </div>
                    @error('nom') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Prénom</label>
                    <div class="input-wrapper">
                        <input type="text" name="prenom" class="form-control @error('prenom') error @enderror" value="{{ old('prenom') }}" required placeholder="Prénom">
                        <i data-lucide="user"></i>
                    </div>
                    @error('prenom') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="form-group full-width">
                    <label>Téléphone</label>
                    <div class="input-wrapper">
                        <input type="tel" name="telephone" class="form-control @error('telephone') error @enderror" value="{{ old('telephone') }}" required placeholder="06 12 34 56 78">
                        <i data-lucide="phone"></i>
                    </div>
                    @error('telephone') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="photo-upload" onclick="document.getElementById('photo-input').click()">
                    <i data-lucide="camera" style="width: 24px; height: 24px; color: var(--text-muted); margin-bottom: 0.5rem;"></i>
                    <p style="font-size: 0.8125rem; font-weight: 700; color: var(--text-main);">Ajouter une photo (Optionnel)</p>
                    <p id="file-status" style="font-size: 0.75rem; color: var(--text-muted);">Aucun fichier choisi</p>
                    <input type="file" name="photo" id="photo-input" hidden accept="image/*" onchange="handleFile(this)">
                </div>
                @error('photo') <div class="error-msg" style="grid-column: span 2; text-align: center;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-auth">
                <i data-lucide="sparkles" style="width: 18px; height: 18px;"></i>
                Créer mon compte
            </button>
        </form>

        <div class="auth-footer">
            Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </div>
</div>
@endsection
