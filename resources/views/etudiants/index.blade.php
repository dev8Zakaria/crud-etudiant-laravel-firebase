@extends('layouts.app')

@section('title', 'Gestion des Étudiants')

@section('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .search-container {
        position: relative;
        margin-bottom: 2rem;
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.05);
        background: white;
        box-shadow: var(--shadow);
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        width: 20px;
        height: 20px;
    }

    .table-card {
        background: white;
        border-radius: 24px;
        padding: 0;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.02);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f8fafc;
        padding: 1.25rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        vertical-align: middle;
    }

    tr:last-child td { border-bottom: none; }

    .student-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .student-img {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        object-fit: cover;
    }

    .student-placeholder-sm {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
    }

    .badge-id {
        background: #f1f5f9;
        color: var(--text-main);
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-family: monospace;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .action-btns {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-view { background: #eff6ff; color: #3b82f6; }
    .btn-edit { background: #fffbeb; color: #d97706; }
    .btn-delete { background: #fef2f2; color: #dc2626; }

    .btn-icon:hover { transform: scale(1.1); }

    .pagination-container {
        padding: 1.5rem;
        border-top: 1px solid rgba(0,0,0,0.05);
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        padding: 1.5rem;
    }

    .modal-overlay.active { display: flex; }

    .modal-window {
        background: white;
        border-radius: 24px;
        width: 100%;
        max-width: 450px;
        padding: 2.5rem;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        animation: modalIn 0.3s ease-out;
    }

    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 style="font-weight: 800; font-size: 1.875rem;">Étudiants</h1>
    <a href="{{ route('etudiants.create') }}" class="btn btn-primary">
        <i data-lucide="plus"></i>
        Nouveau Profil
    </a>
</div>

<div class="search-container">
    <i data-lucide="search" class="search-icon"></i>
    <input 
        type="text" 
        class="search-input" 
        id="searchInput" 
        placeholder="Rechercher par nom, email, apogée..."
        onkeyup="filterTable()"
    >
</div>

<div class="table-card">
    @if($etudiants->count() > 0)
        <table id="studentsTable">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>N° Apogée</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($etudiants as $etudiant)
                    <tr>
                        <td>
                            <div class="student-info">
                                @if($etudiant->photo)
                                    <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="Photo" class="student-img">
                                @else
                                    <div class="student-placeholder-sm">
                                        {{ strtoupper(substr($etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($etudiant->nom, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight: 700; color: var(--text-main);">{{ $etudiant->prenom }} {{ $etudiant->nom }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">Inscrit le {{ $etudiant->created_at->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-id">{{ $etudiant->numero_apogee }}</span>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.875rem;">{{ $etudiant->email }}</td>
                        <td style="color: var(--text-muted); font-size: 0.875rem;">{{ $etudiant->telephone }}</td>
                        <td>
                            <div class="action-btns" style="justify-content: flex-end;">
                                <a href="{{ route('etudiants.show', $etudiant) }}" class="btn-icon btn-view" title="Voir">
                                    <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                                </a>
                                <a href="{{ route('etudiants.edit', $etudiant) }}" class="btn-icon btn-edit" title="Modifier">
                                    <i data-lucide="edit-2" style="width: 18px; height: 18px;"></i>
                                </a>
                                <button onclick="confirmDelete({{ $etudiant->id }})" class="btn-icon btn-delete" title="Supprimer">
                                    <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container">
            {{ $etudiants->links() }}
        </div>
    @else
        <div class="empty-state">
            <i data-lucide="user-x" class="empty-icon"></i>
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Aucun étudiant trouvé</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Votre liste est actuellement vide.</p>
            <a href="{{ route('etudiants.create') }}" class="btn btn-primary">
                <i data-lucide="plus"></i>
                Ajouter le premier
            </a>
        </div>
    @endif
</div>

<!-- Modern Delete Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-window">
        <div style="width: 64px; height: 64px; background: #fef2f2; color: #dc2626; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
            <i data-lucide="alert-triangle" style="width: 32px; height: 32px;"></i>
        </div>
        <h2 style="text-align: center; font-weight: 800; margin-bottom: 0.75rem;">Supprimer l'étudiant ?</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Cette action est définitive et toutes les données associées seront perdues.</p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <button onclick="closeModal()" class="btn" style="background: #f1f5f9; color: var(--text-main); justify-content: center;">Annuler</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary" style="background: #dc2626; width: 100%; justify-content: center;">Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('studentsTable');
        if (!table) return;
        
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent || row.innerText;
            row.style.display = text.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
        }
    }

    function confirmDelete(id) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = '/etudiants/' + id;
        modal.classList.add('active');
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    window.onclick = (e) => {
        if (e.target.classList.contains('modal-overlay')) closeModal();
    }

    lucide.createIcons();
</script>
@endsection
