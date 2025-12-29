@extends('layouts.app')

@section('title', 'Mot de passe oublié - Gestion Étudiants')

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
        max-width: 440px;
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
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
    }

    .auth-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .input-wrapper {
        position: relative;
        display: block;
    }

    .input-wrapper i, .input-wrapper svg {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        width: 18px;
        height: 18px;
        transition: color 0.2s;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1.25rem 0.875rem 3.25rem;
        border-radius: 16px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.2s;
        display: block;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .form-control:focus ~ i, 
    .form-control:focus ~ svg {
        color: var(--primary);
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
    }

    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.3);
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #f1f5f9;
        font-size: 0.9375rem;
        color: var(--text-muted);
    }

    .auth-footer a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
    }

    .error-msg {
        color: var(--accent);
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i data-lucide="key-round" style="width: 32px; height: 32px;"></i>
            </div>
            <h1 class="auth-title">Mot de passe oublié ?</h1>
            <p class="auth-subtitle">Entrez votre email pour recevoir un lien de réinitialisation</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert" style="margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ session('status') }}
            </div>
        @endif

        @if (session('firebase_link'))
            <div class="alert alert-success" role="alert" style="margin-bottom: 1.5rem; font-size: 0.85rem; background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; border-radius: 12px; padding: 1rem;">
                <strong>Lien généré (Mode Démo) :</strong><br>
                <p>Cliquez ci-dessous pour changer le mot de passe :</p>
                <a href="{{ session('firebase_link') }}" target="_blank" style="word-break: break-all; color: #059669; text-decoration: underline; display: block; margin-top: 0.5rem;">
                    {{ session('firebase_link') }}
                </a>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label>Adresse Email</label>
                <div class="input-wrapper">
                    <input type="email" name="email" class="form-control @error('email') error @enderror" value="{{ old('email') }}" required autofocus placeholder="nom@exemple.com">
                    <i data-lucide="mail"></i>
                </div>
                @error('email') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-auth">
                Envoyer le lien
                <i data-lucide="send" style="width: 18px; height: 18px;"></i>
            </button>
        </form>

        <div class="auth-footer">
            <a href="{{ route('login') }}">Retour à la connexion</a>
        </div>
    </div>
</div>
@endsection
