@extends('layouts.app')

@section('header')
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-5 fw-bold mb-3">
            <i class="fas fa-download me-3"></i>Export de mes données
        </h1>
        <p class="lead mb-0">Téléchargez vos données personnelles et votre historique d'achat</p>
    </div>
@endsection

@section('content')
    <style>
    /* Forcer le fond clair sur toutes les cartes de la page d'export */
    .card-modern,
    .bg-light,
    .alert {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%) !important;
        color: #2c3e50 !important;
        border: 1px solid #e9ecef !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
        border-radius: 16px !important;
    }

    .card-modern *,
    .bg-light *,
    .alert * {
        color: inherit !important;
    }

    /* Styles spécifiques pour les cartes d'export */
    .card-modern {
        padding: 1.5rem !important;
        transition: all 0.3s ease;
    }

    .card-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
    }

    /* Styles pour les sous-cartes d'information */
    .bg-light {
        background: #f8f9fa !important;
        border: 1px solid #e9ecef !important;
        border-radius: 12px !important;
        padding: 1.5rem !important;
    }

    /* Styles pour les icônes */
    .fa-2x {
        color: #667eea !important;
    }

    .text-primary {
        color: #667eea !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    /* Styles pour les boutons */
    .btn-primary {
        background: #667eea !important;
        border-color: #667eea !important;
        color: white !important;
    }

    .btn-primary:hover {
        background: #5a67d8 !important;
        border-color: #5a67d8 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-success {
        background: #28a745 !important;
        border-color: #28a745 !important;
        color: white !important;
    }

    .btn-success:hover {
        background: #218838 !important;
        border-color: #218838 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-danger {
        background: #dc3545 !important;
        border-color: #dc3545 !important;
        color: white !important;
    }

    .btn-danger:hover {
        background: #c82333 !important;
        border-color: #c82333 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    /* Styles pour les alertes */
    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%) !important;
        border-color: #bee5eb !important;
        color: #0c5460 !important;
    }

    /* Styles pour les listes */
    .list-unstyled li {
        color: #495057 !important;
        margin-bottom: 0.5rem;
    }

    .list-unstyled strong {
        color: #2c3e50 !important;
        font-weight: 600;
    }

    /* Styles pour les icônes dans les listes */
    .text-success {
        color: #28a745 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    /* Styles pour les textes */
    .text-muted {
        color: #6c757d !important;
    }

    .small {
        color: #6c757d !important;
    }

    /* Styles pour les titres */
    h4, h6 {
        color: #2c3e50 !important;
        font-weight: 700;
    }

    /* Styles pour les paragraphes */
    p {
        color: #495057 !important;
    }
    </style>
    <div class="row g-4">
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card-modern p-4">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-file-export me-2"></i>Mes données personnelles
                </h4>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <h6 class="fw-bold mb-2">Informations personnelles</h6>
                            <ul class="list-unstyled">
                                <li><strong>Nom :</strong> {{ auth()->user()->name }}</li>
                                <li><strong>Email :</strong> {{ auth()->user()->email }}</li>
                                <li><strong>Membre depuis :</strong> {{ auth()->user()->created_at->format('d/m/Y') }}</li>
                                <li><strong>Total commandes :</strong> {{ auth()->user()->orders()->count() }}</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <h6 class="fw-bold mb-2">Statistiques d'achat</h6>
                            <ul class="list-unstyled">
                                <li><strong>Total dépensé :</strong> {{ number_format(auth()->user()->orders()->sum('total'), 0, ',', ' ') }} FCFA</li>
                                <li><strong>Panier moyen :</strong> {{ number_format(auth()->user()->orders()->avg('total') ?? 0, 0, ',', ' ') }} FCFA</li>
                                <li><strong>Dernière commande :</strong> {{ auth()->user()->orders()->latest()->first()?->created_at->format('d/m/Y') ?? 'Aucune' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="fw-bold mb-3">Format d'export</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card-modern p-3 text-center">
                                <i class="fas fa-file-json fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">JSON</h6>
                                <p class="small text-muted">Format structuré pour développeurs</p>
                                <button class="btn btn-primary btn-sm" onclick="exportData('json')">
                                    <i class="fas fa-download me-1"></i>Exporter JSON
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card-modern p-3 text-center">
                                <i class="fas fa-file-csv fa-2x text-success mb-2"></i>
                                <h6 class="fw-bold">CSV</h6>
                                <p class="small text-muted">Format compatible Excel</p>
                                <button class="btn btn-success btn-sm" onclick="exportData('csv')">
                                    <i class="fas fa-download me-1"></i>Exporter CSV
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card-modern p-3 text-center">
                                <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                <h6 class="fw-bold">PDF</h6>
                                <p class="small text-muted">Rapport imprimable</p>
                                <button class="btn btn-danger btn-sm" onclick="exportData('pdf')">
                                    <i class="fas fa-download me-1"></i>Exporter PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4" data-aos="fade-left">
            <div class="card-modern p-4">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-shield-alt me-2"></i>Protection des données
                </h4>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Vos données sont protégées</strong>
                    <p class="mb-0 small mt-2">Nous respectons votre vie privée. Vos données ne sont utilisées que pour améliorer votre expérience d'achat.</p>
                </div>
                
                <div class="mt-4">
                    <h6 class="fw-bold mb-3">Ce qui est inclus :</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Historique des commandes</li>
                        <li><i class="fas fa-check text-success me-2"></i>Produits achetés</li>
                        <li><i class="fas fa-check text-success me-2"></i>Montants dépensés</li>
                        <li><i class="fas fa-check text-success me-2"></i>Dates d'achat</li>
                        <li><i class="fas fa-check text-success me-2"></i>Statuts des commandes</li>
                    </ul>
                </div>
                
                <div class="mt-4">
                    <h6 class="fw-bold mb-3">Ce qui n'est PAS inclus :</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-times text-danger me-2"></i>Informations de paiement</li>
                        <li><i class="fas fa-times text-danger me-2"></i>Adresses de livraison</li>
                        <li><i class="fas fa-times text-danger me-2"></i>Mots de passe</li>
                        <li><i class="fas fa-times text-danger me-2"></i>Données sensibles</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function exportData(format) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Génération...';
    button.disabled = true;
    
    fetch('{{ route("analytics.export") }}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (format === 'json') {
            downloadJSON(data);
        } else if (format === 'csv') {
            downloadCSV(data);
        } else if (format === 'pdf') {
            downloadPDF(data);
        }
        
        button.innerHTML = '<i class="fas fa-check me-1"></i>Terminé !';
        button.classList.remove('btn-primary', 'btn-success', 'btn-danger');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('btn-success');
            if (format === 'json') button.classList.add('btn-primary');
            else if (format === 'csv') button.classList.add('btn-success');
            else if (format === 'pdf') button.classList.add('btn-danger');
        }, 2000);
    })
    .catch(error => {
        console.error('Erreur:', error);
        button.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Erreur';
        button.classList.remove('btn-primary', 'btn-success', 'btn-danger');
        button.classList.add('btn-danger');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
            button.classList.remove('btn-danger');
            if (format === 'json') button.classList.add('btn-primary');
            else if (format === 'csv') button.classList.add('btn-success');
            else if (format === 'pdf') button.classList.add('btn-danger');
        }, 2000);
    });
}

function downloadJSON(data) {
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `eazystore_data_${new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
}

function downloadCSV(data) {
    let csv = 'Commande,Date,Statut,Total,Produits\n';
    
    data.orders.forEach(order => {
        const products = order.items.map(item => `${item.product} (x${item.quantity})`).join('; ');
        csv += `${order.order_id},${order.date},${order.status},${order.total} FCFA,"${products}"\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `eazystore_orders_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
}

function downloadPDF(data) {
    // Simulation d'export PDF (dans un vrai projet, on utiliserait une librairie comme DOMPDF)
    alert('Fonctionnalité PDF en cours de développement');
}
</script>
@endpush 