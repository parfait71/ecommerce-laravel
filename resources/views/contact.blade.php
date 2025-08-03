@extends('layouts.app')

@section('header')
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-5 fw-bold mb-3">
            <i class="fas fa-phone me-3"></i>Contactez-nous
        </h1>
        <p class="lead mb-0">Notre équipe est là pour vous aider</p>
    </div>
@endsection

@section('content')
    <!-- Informations de contact -->
    <div class="row g-4 mb-5">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h5 class="fw-bold mb-2">Téléphone</h5>
                <p class="text-muted mb-3">Appelez-nous directement</p>
                <a href="tel:+221766762542" class="btn btn-primary btn-modern">
                    <i class="fas fa-phone me-2"></i>+221 76 676 25 42
                </a>
            </div>
        </div>
        
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h5 class="fw-bold mb-2">Email</h5>
                <p class="text-muted mb-3">Envoyez-nous un message</p>
                <a href="mailto:contact@eazystore.com" class="btn btn-success btn-modern">
                    <i class="fas fa-envelope me-2"></i>contact@eazystore.com
                </a>
            </div>
        </div>
        
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h5 class="fw-bold mb-2">Adresse</h5>
                <p class="text-muted mb-3">Notre localisation</p>
                <span class="text-muted">
                    <i class="fas fa-map-marker-alt me-2"></i>Dakar, Sénégal
                </span>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <!-- Formulaire de contact -->
        <div class="col-lg-8" data-aos="fade-right">
            <div class="contact-section">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-paper-plane me-2"></i>Envoyez-nous un message
                </h4>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

                <form method="POST" action="{{ route('contact.send') }}" id="contactForm">
            @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">
                                <i class="fas fa-user me-2"></i>Nom complet
                            </label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   placeholder="Votre nom complet" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="votre@email.com" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="col-12">
                            <label for="subject" class="form-label fw-bold">
                                <i class="fas fa-tag me-2"></i>Sujet
                            </label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Choisissez un sujet</option>
                                <option value="Question générale">Question générale</option>
                                <option value="Support technique">Support technique</option>
                                <option value="Commande">Question sur une commande</option>
                                <option value="Paiement">Problème de paiement</option>
                                <option value="Livraison">Question sur la livraison</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label for="message" class="form-label fw-bold">
                                <i class="fas fa-comment me-2"></i>Message
                            </label>
                            <textarea class="form-control" id="message" name="message" rows="5" 
                                      placeholder="Décrivez votre demande en détail..." required>{{ old('message') }}</textarea>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-modern" id="submitContact">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations supplémentaires -->
        <div class="col-lg-4" data-aos="fade-left">
            <div class="info-card">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-info-circle me-2"></i>Informations utiles
                </h5>
                
                <div class="mb-4">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-clock me-2"></i>Horaires d'ouverture
                    </h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Lundi - Vendredi :</strong><br>
                            <small class="text-muted">8h00 - 18h00</small>
                        </li>
                        <li class="mb-2">
                            <strong>Samedi :</strong><br>
                            <small class="text-muted">9h00 - 16h00</small>
                        </li>
                        <li class="mb-2">
                            <strong>Dimanche :</strong><br>
                            <small class="text-muted">Fermé</small>
                        </li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-headset me-2"></i>Support client
                    </h6>
                    <p class="text-muted small">
                        Notre équipe de support est disponible pour vous aider avec toutes vos questions concernant nos produits et services.
                    </p>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-shipping-fast me-2"></i>Livraison
                    </h6>
                    <p class="text-muted small">
                        Livraison gratuite à partir de 10 000 FCFA. Délai de livraison : 24-48h.
                    </p>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Conseil :</strong> Pour une réponse plus rapide, précisez bien votre demande dans le message.
                </div>
            </div>

            <!-- FAQ rapide -->
            <div class="info-card mt-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-question-circle me-2"></i>Questions fréquentes
                </h5>
                
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Comment suivre ma commande ?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Connectez-vous à votre compte et allez dans "Mes commandes" pour voir le statut de votre commande.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Quels sont les modes de paiement ?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Nous acceptons Wave, Orange Money, virement bancaire et paiement à la livraison.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Délai de livraison ?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                La livraison se fait en 24-48h après confirmation du paiement.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitContact');
    
    form.addEventListener('submit', function(e) {
        // Animation de chargement
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
        submitBtn.disabled = true;
    });
});
</script>
@endpush 