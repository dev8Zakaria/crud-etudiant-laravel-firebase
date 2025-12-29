@extends('layouts.app')

@section('title', 'Nouveau Profil Étudiant')

@section('styles')
<style>
    .page-header {
        margin-bottom: 2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 2rem;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.02);
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 2rem;
        color: var(--text-main);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-main);
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1.25rem;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .form-control.error { border-color: var(--accent); }

    .error-msg {
        color: var(--accent);
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .input-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    /* Photo Upload Styling */
    .photo-upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .photo-upload-zone:hover {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.02);
    }

    #photo-preview {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        object-fit: cover;
        margin: 0 auto 1rem;
        display: none;
        box-shadow: var(--shadow);
    }

    .upload-placeholder {
        color: var(--text-muted);
    }

    .upload-placeholder i {
        width: 32px;
        height: 32px;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 1024px) {
        .form-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.875rem; margin-bottom: 0.5rem;">
        <a href="{{ route('etudiants.index') }}" style="color: inherit; text-decoration: none;">Étudiants</a>
        <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
        <span style="color: var(--primary); font-weight: 600;">Nouveau Profil</span>
    </div>
    <h1 style="font-weight: 800; font-size: 1.875rem;">Ajouter un Étudiant</h1>
</div>

<form method="POST" action="{{ route('etudiants.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-grid">
        <div class="form-card">
            <div class="form-section">
                <div class="form-section-title">
                    <i data-lucide="shield-check" style="color: var(--primary);"></i>
                    Compte Utilisateur
                </div>
                
                <div class="input-row">
                    <div class="form-group">
                        <label>Nom d'utilisateur <span style="color: var(--accent);">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') error @enderror" value="{{ old('name') }}" required placeholder="ex: jsmith">
                        @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Email Institutionnel <span style="color: var(--accent);">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') error @enderror" value="{{ old('email') }}" required placeholder="j.smith@univ.ma">
                        @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Mot de passe <span style="color: var(--accent);">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') error @enderror" required placeholder="••••••••">
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">Minimum 8 caractères sécurisés.</p>
                    @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-section" style="margin-top: 3rem;">
                <div class="form-section-title">
                    <i data-lucide="book-open" style="color: var(--primary);"></i>
                    Détails Académiques
                </div>

                <div class="form-group">
                    <label>Numéro d'Apogée <span style="color: var(--accent);">*</span></label>
                    <input type="text" name="numero_apogee" class="form-control @error('numero_apogee') error @enderror" value="{{ old('numero_apogee') }}" required placeholder="Ex: 22004512">
                    @error('numero_apogee') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="input-row">
                    <div class="form-group">
                        <label>Nom <span style="color: var(--accent);">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') error @enderror" value="{{ old('nom') }}" required placeholder="Nom">
                        @error('nom') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Prénom <span style="color: var(--accent);">*</span></label>
                        <input type="text" name="prenom" class="form-control @error('prenom') error @enderror" value="{{ old('prenom') }}" required placeholder="Prénom">
                        @error('prenom') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Téléphone <span style="color: var(--accent);">*</span></label>
                    <input type="tel" name="telephone" class="form-control @error('telephone') error @enderror" value="{{ old('telephone') }}" required placeholder="06 XX XX XX XX">
                    @error('telephone') <div class="error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-top: 3rem; display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('etudiants.index') }}" class="btn" style="background: #f1f5f9; color: var(--text-main);">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i>
                    Créer le Profil
                </button>
            </div>
        </div>

        <div class="side-panel">
            <div class="form-card">
                <div class="form-section-title">
                    <i data-lucide="camera" style="color: var(--primary);"></i>
                    Photo
                </div>
                
                <div class="photo-upload-zone" onclick="document.getElementById('photo-input').click()">
                    <img id="photo-preview" src="#" alt="Aperçu">
                    <div id="upload-placeholder" class="upload-placeholder">
                        <i data-lucide="upload-cloud"></i>
                        <p style="font-size: 0.875rem; font-weight: 600;">Cliquez pour uploader</p>
                        <p style="font-size: 0.75rem;">PNG, JPG (Max 2MB)</p>
                    </div>
                    <input type="file" name="photo" id="photo-input" hidden accept="image/*" onchange="handlePreview(this)">
                </div>
                @error('photo') <div class="error-msg" style="text-align: center;">{{ $message }}</div> @enderror
                
                <div style="margin-top: 2rem; background: #f8fafc; padding: 1rem; border-radius: 12px; font-size: 0.75rem; color: var(--text-muted);">
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <i data-lucide="info" style="width: 14px; height: 14px;"></i>
                        <span>Assurez-vous que le visage est bien visible pour la carte d'étudiant.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    function handlePreview(input) {
        const preview = document.getElementById('photo-preview');
        const placeholder = document.getElementById('upload-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    lucide.createIcons();
</script>
@endsection
