@extends('layouts.admin')

@section('header')
    <div class="page-header" data-aos="fade-up">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">
                    <i class="fas fa-users me-3"></i>Gestion des Utilisateurs
                </h1>
                <p class="page-subtitle">Administrez les comptes clients et les permissions</p>
            </div>
            <div class="header-right">
                <div class="stats-summary">
                    <div class="stat-item">
                        <span class="stat-number">{{ $users->count() }}</span>
                        <span class="stat-label">Utilisateurs</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $users->where('is_admin', true)->count() }}</span>
                        <span class="stat-label">Admins</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-modern" role="alert" data-aos="fade-up">
            <div class="alert-content">
                <i class="fas fa-check-circle me-2"></i>
                <div class="alert-text">
                    <strong>Succès !</strong>
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-modern" role="alert" data-aos="fade-up">
            <div class="alert-content">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div class="alert-text">
                    <strong>Erreur !</strong>
                    <div class="alert-message">{{ session('error') }}</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Filtres et recherche -->
    <div class="filters-section mb-4" data-aos="fade-up">
        <div class="filters-container">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="userSearch" class="search-input" placeholder="Rechercher un utilisateur...">
            </div>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-users me-2"></i>Tous
                </button>
                <button class="filter-btn" data-filter="admin">
                    <i class="fas fa-user-shield me-2"></i>Admins
                </button>
                <button class="filter-btn" data-filter="user">
                    <i class="fas fa-user me-2"></i>Utilisateurs
                </button>
            </div>
        </div>
    </div>

    <!-- Grille des utilisateurs -->
    <div class="users-grid" data-aos="fade-up">
        @forelse ($users as $user)
            <div class="user-card" data-user-type="{{ $user->is_admin ? 'admin' : 'user' }}" data-user-name="{{ strtolower($user->name) }}" data-user-email="{{ strtolower($user->email) }}">
                <div class="user-header">
                    <div class="user-avatar">
                        <img src="{{ asset('images/avatar.png') }}" alt="{{ $user->name }}" class="avatar-img">
                        @if($user->is_admin)
                            <div class="admin-badge">
                                <i class="fas fa-crown"></i>
                            </div>
                        @endif
                    </div>
                    <div class="user-status">
                        <span class="status-dot {{ $user->is_admin ? 'admin' : 'user' }}"></span>
                        <span class="status-text">{{ $user->is_admin ? 'Administrateur' : 'Utilisateur' }}</span>
                    </div>
                </div>
                
                <div class="user-info">
                    <h3 class="user-name">{{ $user->name }}</h3>
                    <p class="user-email">{{ $user->email }}</p>
                    <div class="user-meta">
                        <span class="meta-item">
                            <i class="fas fa-calendar me-1"></i>
                            Inscrit le {{ $user->created_at->format('d/m/Y') }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-clock me-1"></i>
                            {{ $user->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                
                <div class="user-actions">
                    <a href="{{ route('admin.users.edit', $user) }}" class="action-btn edit-btn">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                    <button class="action-btn delete-btn" onclick="confirmDelete(event, '{{ $user->name }}', '{{ route('admin.users.destroy', $user) }}', {{ $user->id }}, {{ auth()->id() }})">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state" data-aos="fade-up">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="empty-title">Aucun utilisateur trouvé</h3>
                <p class="empty-description">Aucun utilisateur n'est enregistré dans le système.</p>
            </div>
        @endforelse
    </div>

    <!-- Formulaire de suppression caché -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Recherche en temps réel
    const searchInput = document.getElementById('userSearch');
    const userCards = document.querySelectorAll('.user-card');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        userCards.forEach(card => {
            const userName = card.dataset.userName;
            const userEmail = card.dataset.userEmail;
            
            if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Filtres par type d'utilisateur
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            userCards.forEach(card => {
                const userType = card.dataset.userType;
                
                if (filter === 'all' || userType === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});

function confirmDelete(event, userName, deleteUrl, userId, currentUserId) {
    // Empêcher la propagation de l'événement
    event.preventDefault();
    event.stopPropagation();

    // Empêcher la suppression de son propre compte
    if (userId === currentUserId) {
        alert('❌ Vous ne pouvez pas supprimer votre propre compte.\n\nPour supprimer votre compte, contactez un autre administrateur.');
        return false;
    }

    // Confirmation avec plus de détails
    const confirmation = confirm(
        `⚠️ ATTENTION : Suppression d'utilisateur\n\n` +
        `Utilisateur : ${userName}\n` +
        `ID : ${userId}\n\n` +
        `Cette action est irréversible !\n` +
        `Toutes les données de cet utilisateur seront supprimées.\n\n` +
        `Êtes-vous sûr de vouloir continuer ?`
    );

    if (confirmation) {
        // Afficher un indicateur de chargement
        const deleteBtn = event.target.closest('.delete-btn');
        if (deleteBtn) {
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Suppression...';
            deleteBtn.disabled = true;
        }

        // Créer et soumettre le formulaire
        const form = document.getElementById('deleteForm');
        if (form) {
            form.action = deleteUrl;
            form.submit();
        } else {
            // Fallback si le formulaire n'existe pas
            const newForm = document.createElement('form');
            newForm.method = 'POST';
            newForm.action = deleteUrl;
            newForm.style.display = 'none';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            newForm.appendChild(csrfToken);
            newForm.appendChild(methodField);
            document.body.appendChild(newForm);
            newForm.submit();
        }
    }

    return false;
}
</script>
@endpush

<style>
/* Header de la page */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.stats-summary {
    display: flex;
    gap: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Alertes modernes améliorées */
.alert-modern {
    border-radius: 16px;
    border: none;
    padding: 1.5rem;
    margin-bottom: 2rem;
    font-weight: 500;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.alert-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-success::before {
    background: #28a745;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert-danger::before {
    background: #dc3545;
}

.alert-content {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.alert-text {
    flex: 1;
}

.alert-text strong {
    display: block;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.alert-message {
    font-size: 1rem;
    line-height: 1.5;
    white-space: pre-line;
}

.alert-modern i {
    font-size: 1.5rem;
    margin-top: 0.2rem;
}

/* Section des filtres */
.filters-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.filters-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid #e9ecef;
    background: white;
    border-radius: 12px;
    font-size: 0.9rem;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.filter-btn.active,
.filter-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.export-buttons {
    display: flex;
    gap: 0.5rem;
}

.export-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid #e9ecef;
    background: white;
    border-radius: 12px;
    font-size: 0.9rem;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.export-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    text-decoration: none;
}

.pdf-btn:hover {
    background: #dc3545;
    color: white;
    border-color: #dc3545;
}

.excel-btn:hover {
    background: #28a745;
    color: white;
    border-color: #28a745;
}

/* Grille des utilisateurs */
.users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.user-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.user-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.user-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.user-avatar {
    position: relative;
}

.avatar-img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e9ecef;
}

.admin-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 25px;
    height: 25px;
    background: linear-gradient(135deg, #ffc107, #ff8c00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
}

.admin-badge i {
    font-size: 0.8rem;
    color: white;
}

.user-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-dot.admin {
    background: #ffc107;
}

.status-dot.user {
    background: #28a745;
}

.status-text {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

.user-info {
    margin-bottom: 1.5rem;
}

.user-name {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.user-email {
    color: #6c757d;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.user-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    font-size: 0.85rem;
    color: #6c757d;
    display: flex;
    align-items: center;
}

.user-actions {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    flex: 1;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.edit-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.edit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    color: white;
}

.delete-btn {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.delete-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

/* État vide */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-icon i {
    font-size: 2rem;
    color: #6c757d;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.empty-description {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .filters-container {
        flex-direction: column;
        gap: 1rem;
    }
    
    .search-box {
        max-width: 100%;
    }
    
    .filter-buttons {
        justify-content: center;
    }
    
    .users-grid {
        grid-template-columns: 1fr;
    }
    
    .user-actions {
        flex-direction: column;
    }
}
</style>
