

<?php $__env->startSection('title', 'EazyStore - Votre boutique en ligne'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="hero-section bg-gradient-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Bienvenue chez EazyStore</h1>
                    <p class="lead mb-4">Découvrez notre sélection de produits de qualité à des prix compétitifs. Livraison rapide et service client exceptionnel.</p>
                    <div class="d-flex gap-3">
                        <a href="<?php echo e(route('catalogue')); ?>" class="btn btn-light btn-lg fw-bold" style="pointer-events: auto; cursor: pointer;" onclick="console.log('Catalogue clicked'); return true;">
                            <i class="fas fa-shopping-cart me-2"></i>Voir nos produits
                        </a>
                        <?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg" style="pointer-events: auto; cursor: pointer;" onclick="console.log('Login clicked'); return true;">
                                <i class="fas fa-user me-2"></i>Se connecter
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="EazyStore Logo" class="img-fluid" style="max-height: 300px;"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none; text-align: center;">
                        <h1 style="font-size: 3rem; font-weight: bold; color: white; margin-bottom: 1rem;">EazyStore</h1>
                        <p style="font-size: 1.2rem; color: rgba(255,255,255,0.9);">Votre boutique en ligne</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mb-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title fw-bold">Livraison Rapide</h5>
                        <p class="card-text text-muted">Recevez vos commandes en 24-48h dans toute la région.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shield-alt fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title fw-bold">Paiement Sécurisé</h5>
                        <p class="card-text text-muted">Transactions sécurisées avec Wave et autres moyens de paiement.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-headset fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title fw-bold">Service Client</h5>
                        <p class="card-text text-muted">Support disponible 7j/7 pour répondre à vos questions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5 fw-bold">Produits Populaires</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-muted mb-4">Découvrez nos produits les plus appréciés par nos clients</p>
                <a href="<?php echo e(route('catalogue')); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-eye me-2"></i>Voir tout le catalogue
                </a>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="bg-light py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">À propos d'EazyStore</h2>
                    <p class="lead mb-4">EazyStore est votre partenaire de confiance pour tous vos besoins en ligne. Nous nous engageons à vous offrir une expérience d'achat exceptionnelle avec des produits de qualité et un service client irréprochable.</p>
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Produits authentiques</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Prix compétitifs</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Livraison rapide</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Support 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="<?php echo e(asset('images/store-front.jpg')); ?>" alt="Notre boutique" class="img-fluid rounded shadow" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-4">Besoin d'assistance ?</h2>
                <p class="lead mb-4">Notre équipe est disponible 7j/7 pour vous accompagner dans vos achats en ligne</p>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-phone fa-2x text-primary mb-3"></i>
                                <h5 class="card-title">Appel direct</h5>
                                <p class="card-text">+221 78 920 13 38</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fab fa-whatsapp fa-2x text-success mb-3"></i>
                                <h5 class="card-title">WhatsApp Business</h5>
                                <a href="https://wa.me/221789201338" target="_blank" class="card-text text-decoration-none">
                                    +221 78 920 13 38
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope fa-2x text-info mb-3"></i>
                                <h5 class="card-title">Support Email</h5>
                                <a href="mailto:gnaweparfait1@gmail.com" class="card-text text-decoration-none">
                                    gnaweparfait1@gmail.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.feature-icon {
    transition: transform 0.3s ease;
}

.card:hover .feature-icon {
    transform: scale(1.1);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* S'assurer que les liens sont cliquables */
.btn {
    pointer-events: auto !important;
    cursor: pointer !important;
    z-index: 10;
    position: relative;
}

.btn:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}
</style>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/home.blade.php ENDPATH**/ ?>