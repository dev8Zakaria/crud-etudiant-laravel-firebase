@extends('layouts.app')

@section('title', 'Modifier le Profil')

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

    /* Photo Styling */
    .current-photo-card {
        text-align: center;
        margin-bottom: 2rem;
    }

    #photo-preview {
        width: 150px;
        height: 150px;
        border-radius: 30px;
        object-fit: cover;
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow);
        border: 4px solid white;
    }

    .photo-upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8fafc;
    }

    .photo-upload-zone:hover {
        border-color: var(--primary);
        background: rgba(99, 102, 241, 0.02);
    }

    .upload-placeholder {
        color: var(--text-muted);
        font-size: 0.75rem;
    }

    .upload-placeholder i {
        width: 24px;
        height: 24px;
        margin-bottom: 0.25rem;
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
        <span style="color: var(--primary); font-weight: 600;">{{ $etudiant->prenom }} {{ $etudiant->nom }}</span>
    </div>
    <h1 style="font-weight: 800; font-size: 1.875rem;">Modifier le Profil</h1>
</div>

<form method="POST" action="{{ route('etudiants.update', $etudiant) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-grid">
        <div class="form-card">
            <div class="form-section">
                <div class="form-section-title">
                    <i data-lucide="book-open" style="color: var(--primary);"></i>
                    Informations Académiques
                </div>

                <div class="form-group">
                    <label>Numéro d'Apogée <span style="color: var(--accent);">*</span></label>
                    <input type="text" name="numero_apogee" class="form-control @error('numero_apogee') error @enderror" value="{{ old('numero_apogee', $etudiant->numero_apogee) }}" required>
                    @error('numero_apogee') <div class="error-msg">{{ $message }}</div> @enderror
                </div>

                <div class="input-row">
                    <div class="form-group">
                        <label>Nom <span style="color: var(--accent);">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') error @enderror" value="{{ old('nom', $etudiant->nom) }}" required>
                        @error('nom') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Prénom <span style="color: var(--accent);">*</span></label>
                        <input type="text" name="prenom" class="form-control @error('prenom') error @enderror" value="{{ old('prenom', $etudiant->prenom) }}" required>
                        @error('prenom') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="input-row">
                    <div class="form-group">
                        <label>Email <span style="color: var(--accent);">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') error @enderror" value="{{ old('email', $etudiant->email) }}" required>
                        @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Téléphone <span style="color: var(--accent);">*</span></label>
                        <input type="tel" name="telephone" class="form-control @error('telephone') error @enderror" value="{{ old('telephone', $etudiant->telephone) }}" required>
                        @error('telephone') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div style="margin-top: 3rem; display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('etudiants.index') }}" class="btn" style="background: #f1f5f9; color: var(--text-main);">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="refresh-cw"></i>
                    Mettre à jour
                </button>
            </div>
        </div>

        <div class="side-panel">
            <div class="form-card">
                <div class="form-section-title">
                    <i data-lucide="camera" style="color: var(--primary);"></i>
                    Photo
                </div>
                
                <div class="current-photo-card">
                    @if($etudiant->photo)
                        <img id="photo-preview" src="{{ asset('storage/' . $etudiant->photo) }}" alt="Photo">
                    @else
                        <div id="photo-preview-placeholder" style="width: 150px; height: 150px; border-radius: 30px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 800; margin: 0 auto 1.5rem; box-shadow: var(--shadow);">
                            {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
                        </div>
                        <img id="photo-preview" src="#" alt="Aperçu" style="display: none;">
                    @endif
                </div>

                <div class="photo-upload-zone" onclick="document.getElementById('photo-input').click()">
                    <div class="upload-placeholder">
                        <i data-lucide="upload"></i>
                        <p style="font-weight: 700;">Changer la photo</p>
                    </div>
                    <input type="file" name="photo" id="photo-input" hidden accept="image/*" onchange="handlePreview(this)">
                </div>
                @error('photo') <div class="error-msg" style="text-align: center;">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    function handlePreview(input) {
        const preview = document.getElementById('photo-preview');
        const placeholderImg = document.getElementById('photo-preview-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholderImg) placeholderImg.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    lucide.createIcons();
</script>
@endsection
