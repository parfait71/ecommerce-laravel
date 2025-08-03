@extends('layouts.app')

@section('header')
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-5 fw-bold mb-3">
            <i class="fas fa-question-circle me-3"></i>Questions fréquentes
        </h1>
        <p class="lead mb-0">Trouvez rapidement les réponses à vos questions</p>
    </div>
@endsection

@section('content')
    <!-- Barre de recherche -->
    <div class="row justify-content-center mb-5" data-aos="fade-up">
        <div class="col-lg-6">
            <div class="search-container">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" id="faqSearch" 
                           placeholder="Rechercher dans les questions fréquentes...">
                </div>
            </div>
        </div>
    </div>

    <!-- Catégories -->
    <div class="row g-4 mb-5" data-aos="fade-up">
        <div class="col-md-3">
            <div class="category-card active" data-category="all">
                <div class="text-center p-3">
                    <i class="fas fa-th-large fa-2x mb-2"></i>
                    <h6 class="fw-bold">Toutes</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="category-card" data-category="commandes">
                <div class="text-center p-3">
                    <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                    <h6 class="fw-bold">Commandes</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="category-card" data-category="paiement">
                <div class="text-center p-3">
                    <i class="fas fa-credit-card fa-2x mb-2"></i>
                    <h6 class="fw-bold">Paiement</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="category-card" data-category="livraison">
                <div class="text-center p-3">
                    <i class="fas fa-truck fa-2x mb-2"></i>
                    <h6 class="fw-bold">Livraison</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Accordion -->
    <div class="faq-container" data-aos="fade-up">
        <!-- Commandes -->
        <div class="faq-section" data-category="commandes">
            <h4 class="fw-bold mb-4">
                <i class="fas fa-shopping-bag me-2"></i>Commandes
            </h4>
            
            <div class="accordion" id="faqCommandes">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            <i class="fas fa-question-circle me-2"></i>
                            Comment passer une commande ?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqCommandes">
                        <div class="accordion-body">
                            <p>Pour passer une commande :</p>
                            <ol>
                                <li>Parcourez notre catalogue et ajoutez les produits désirés à votre panier</li>
                                <li>Cliquez sur l'icône du panier pour voir vos articles</li>
                                <li>Vérifiez vos articles et cliquez sur "Passer la commande"</li>
                                <li>Remplissez vos informations de livraison</li>
                                <li>Choisissez votre mode de paiement et confirmez</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            <i class="fas fa-question-circle me-2"></i>
                            Comment suivre ma commande ?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqCommandes">
                        <div class="accordion-body">
                            <p>Pour suivre votre commande :</p>
                            <ul>
                                <li>Connectez-vous à votre compte</li>
                                <li>Allez dans "Mes commandes"</li>
                                <li>Cliquez sur "Voir les détails" de votre commande</li>
                                <li>Vous verrez le statut actuel de votre commande</li>
                            </ul>
                            <p class="mb-0"><strong>Statuts possibles :</strong></p>
                            <ul class="mb-0">
                                <li><span class="badge bg-warning">En attente de paiement</span></li>
                                <li><span class="badge bg-info">En préparation</span></li>
                                <li><span class="badge bg-primary">En livraison</span></li>
                                <li><span class="badge bg-success">Livrée</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            <i class="fas fa-question-circle me-2"></i>
                            Puis-je annuler ma commande ?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqCommandes">
                        <div class="accordion-body">
                            <p>Vous pouvez annuler votre commande dans les cas suivants :</p>
                            <ul>
                                <li><strong>Avant le paiement :</strong> Annulation possible sans frais</li>
                                <li><strong>Après paiement, avant préparation :</strong> Remboursement complet</li>
                                <li><strong>En cours de préparation :</strong> Contactez notre service client</li>
                                <li><strong>En livraison :</strong> Annulation impossible</li>
                            </ul>
                            <p class="mb-0">Pour annuler, contactez-nous au <strong>+221 76 676 25 42</strong> ou par email.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paiement -->
        <div class="faq-section" data-category="paiement">
            <h4 class="fw-bold mb-4">
                <i class="fas fa-credit-card me-2"></i>Paiement
            </h4>
            
            <div class="accordion" id="faqPaiement">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            <i class="fas fa-question-circle me-2"></i>
                            Quels sont les modes de paiement acceptés ?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse show" data-bs-parent="#faqPaiement">
                        <div class="accordion-body">
                            <p>Nous acceptons les modes de paiement suivants :</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        <i class="fas fa-mobile-alt text-primary me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Wave</h6>
                                            <small class="text-muted">Paiement mobile sécurisé</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        <i class="fas fa-mobile-alt text-warning me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Orange Money</h6>
                                            <small class="text-muted">Paiement mobile sécurisé</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        <i class="fas fa-university text-success me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Virement bancaire</h6>
                                            <small class="text-muted">Transfert direct</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        <i class="fas fa-truck text-info me-3"></i>
                                        <div>
                                            <h6 class="fw-bold mb-1">Paiement à la livraison</h6>
                                            <small class="text-muted">Payez à la réception</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            <i class="fas fa-question-circle me-2"></i>
                            Le paiement est-il sécurisé ?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqPaiement">
                        <div class="accordion-body">
                            <p><strong>Oui, votre paiement est 100% sécurisé !</strong></p>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="text-center p-3">
                                        <i class="fas fa-lock text-success fa-2x mb-2"></i>
                                        <h6 class="fw-bold">Données cryptées</h6>
                                        <small class="text-muted">Protection SSL</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3">
                                        <i class="fas fa-shield-alt text-primary fa-2x mb-2"></i>
                                        <h6 class="fw-bold">Protection</h6>
                                        <small class="text-muted">Anti-fraude</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center p-3">
                                        <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                        <h6 class="fw-bold">Garantie</h6>
                                        <small class="text-muted">100% sécurisé</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                            <i class="fas fa-question-circle me-2"></i>
                            Quand serai-je remboursé en cas d'annulation ?
                        </button>
                    </h2>
                    <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqPaiement">
                        <div class="accordion-body">
                            <p>Les délais de remboursement varient selon le mode de paiement :</p>
                            <ul>
                                <li><strong>Wave/Orange Money :</strong> 24-48h</li>
                                <li><strong>Virement bancaire :</strong> 3-5 jours ouvrés</li>
                                <li><strong>Paiement à la livraison :</strong> Pas de remboursement nécessaire</li>
                            </ul>
                            <p class="mb-0">Le remboursement est automatique en cas d'annulation avant la préparation de la commande.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Livraison -->
        <div class="faq-section" data-category="livraison">
            <h4 class="fw-bold mb-4">
                <i class="fas fa-truck me-2"></i>Livraison
            </h4>
            
            <div class="accordion" id="faqLivraison">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                            <i class="fas fa-question-circle me-2"></i>
                            Quels sont les délais de livraison ?
                        </button>
                    </h2>
                    <div id="faq7" class="accordion-collapse collapse show" data-bs-parent="#faqLivraison">
                        <div class="accordion-body">
                            <p>Nos délais de livraison :</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-card p-3">
                                        <h6 class="fw-bold text-primary">
                                            <i class="fas fa-map-marker-alt me-2"></i>Dakar
                                        </h6>
                                        <p class="mb-2">Livraison en 24h</p>
                                        <small class="text-muted">Gratuite à partir de 10 000 FCFA</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card p-3">
                                        <h6 class="fw-bold text-success">
                                            <i class="fas fa-map-marker-alt me-2"></i>Autres villes
                                        </h6>
                                        <p class="mb-2">Livraison en 48-72h</p>
                                        <small class="text-muted">Frais selon la distance</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                            <i class="fas fa-question-circle me-2"></i>
                            Comment fonctionne la livraison gratuite ?
                        </button>
                    </h2>
                    <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqLivraison">
                        <div class="accordion-body">
                            <p><strong>Livraison gratuite automatique :</strong></p>
                            <ul>
                                <li>Pour toute commande de <strong>10 000 FCFA</strong> et plus</li>
                                <li>Valable sur tout le territoire sénégalais</li>
                                <li>Pas de frais supplémentaires</li>
                                <li>Même délai de livraison</li>
        </ul>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Conseil :</strong> Ajoutez des articles à votre panier pour atteindre le seuil de 10 000 FCFA et bénéficier de la livraison gratuite !
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                            <i class="fas fa-question-circle me-2"></i>
                            Puis-je suivre mon livreur en temps réel ?
                        </button>
                    </h2>
                    <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqLivraison">
                        <div class="accordion-body">
                            <p><strong>Oui !</strong> Nous vous informons à chaque étape :</p>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold">Commande confirmée</h6>
                                        <small class="text-muted">Email de confirmation</small>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold">En préparation</h6>
                                        <small class="text-muted">SMS de notification</small>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold">En livraison</h6>
                                        <small class="text-muted">Appel du livreur</small>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="fw-bold">Livrée</h6>
                                        <small class="text-muted">Confirmation de réception</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section contact -->
    <div class="row justify-content-center mt-5" data-aos="fade-up">
        <div class="col-lg-8 text-center">
            <div class="info-card">
                <h4 class="fw-bold mb-3">
                    <i class="fas fa-headset me-2"></i>Besoin d'aide supplémentaire ?
                </h4>
                <p class="text-muted mb-4">
                    Si vous n'avez pas trouvé la réponse à votre question, notre équipe est là pour vous aider.
                </p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="tel:+221766762542" class="btn btn-primary btn-modern w-100">
                            <i class="fas fa-phone me-2"></i>Appeler
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-modern w-100">
                            <i class="fas fa-envelope me-2"></i>Nous écrire
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faqSearch');
    const categoryCards = document.querySelectorAll('.category-card');
    const faqSections = document.querySelectorAll('.faq-section');
    
    // Filtrage par catégorie
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Mettre à jour les cartes actives
            categoryCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrer les sections
            faqSections.forEach(section => {
                if (category === 'all' || section.dataset.category === category) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });
    
    // Recherche
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const accordionItems = document.querySelectorAll('.accordion-item');
        
        accordionItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
                // Ouvrir automatiquement si recherche active
                if (searchTerm.length > 2) {
                    const collapse = item.querySelector('.accordion-collapse');
                    if (collapse) {
                        new bootstrap.Collapse(collapse, { show: true });
                    }
                }
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

<style>
.search-container {
    position: relative;
}

.search-container .form-control {
    border-radius: 25px;
    padding-left: 50px;
}

.search-container .input-group-text {
    border-radius: 25px 0 0 25px;
    border: none;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: -29px;
    top: 17px;
    width: 2px;
    height: 20px;
    background: #e9ecef;
}

.faq-section {
    margin-bottom: 3rem;
}
</style>
@endpush 