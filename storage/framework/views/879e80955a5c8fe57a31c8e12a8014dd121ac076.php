

<?php $__env->startSection('header'); ?>
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-3">
            <?php if(auth()->guard()->check()): ?>
                Bienvenue <?php echo e(explode(' ', Auth::user()->name)[0]); ?> 👋
            <?php else: ?>
                Bienvenue sur EazyStore
            <?php endif; ?>
        </h1>
        <p class="lead mb-4">Votre boutique en ligne de confiance pour tous vos besoins</p>
        <?php if(auth()->guard()->guest()): ?>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-light btn-modern">
                    <i class="fas fa-shopping-bag me-2"></i>Voir le catalogue
                </a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-warning btn-modern">
                    <i class="fas fa-user-plus me-2"></i>Créer un compte
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
        <!-- Dashboard utilisateur connecté -->
        <div class="row g-4 mb-5">
            <!-- Statistiques -->
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stats-card">
                    <i class="fas fa-shopping-cart fa-2x mb-3"></i>
                    <h4 class="fw-bold"><?php echo e(Auth::user()->orders()->count()); ?></h4>
                    <p class="mb-0">Commandes</p>
                </div>
            </div>
            
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stats-card">
                    <i class="fas fa-box fa-2x mb-3"></i>
                    <h4 class="fw-bold"><?php echo e(\App\Models\Product::count()); ?></h4>
                    <p class="mb-0">Produits disponibles</p>
                </div>
            </div>
            
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stats-card">
                    <i class="fas fa-star fa-2x mb-3"></i>
                    <h4 class="fw-bold">4.8</h4>
                    <p class="mb-0">Note moyenne</p>
                </div>
            </div>
            
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stats-card">
                    <i class="fas fa-users fa-2x mb-3"></i>
                    <h4 class="fw-bold"><?php echo e(\App\Models\User::count()); ?></h4>
                    <p class="mb-0">Clients satisfaits</p>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4" data-aos="fade-up">Actions rapides</h3>
            </div>
            
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Catalogue</h5>
                    <p class="text-muted small">Découvrez nos produits</p>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-modern w-100">
                        <i class="fas fa-arrow-right me-2"></i>Explorer
                    </a>
                </div>
            </div>
            
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Mes commandes</h5>
                    <p class="text-muted small">Suivez vos achats</p>
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-success btn-modern w-100">
                        <i class="fas fa-arrow-right me-2"></i>Voir
                    </a>
                </div>
            </div>
            
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Mon panier</h5>
                    <p class="text-muted small">Gérez vos achats</p>
                    <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-warning btn-modern w-100">
                        <i class="fas fa-arrow-right me-2"></i>Accéder
                    </a>
                </div>
            </div>
            
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Mon profil</h5>
                    <p class="text-muted small">Gérez vos informations</p>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-info btn-modern w-100">
                        <i class="fas fa-arrow-right me-2"></i>Modifier
                    </a>
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4" data-aos="fade-up">Nos services</h3>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Livraison rapide</h5>
                    <p class="text-muted">Livraison gratuite pour toute commande supérieure à 10 000 FCFA</p>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Paiement sécurisé</h5>
                    <p class="text-muted">Paiement sécurisé via Wave, Orange Money et virement bancaire</p>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Support 24/7</h5>
                    <p class="text-muted">Notre équipe est disponible pour vous aider à tout moment</p>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Page d'accueil pour visiteurs -->
        <div class="row g-4 mb-5">
            <div class="col-md-6" data-aos="fade-right">
                <div class="info-card h-100">
                    <h3 class="fw-bold mb-4">Pourquoi choisir EazyStore ?</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Produits de qualité garantie
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Livraison rapide et gratuite
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Paiement sécurisé
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Support client 24/7
                        </li>
                    </ul>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-modern">
                        <i class="fas fa-user-plus me-2"></i>Créer un compte
                    </a>
                </div>
            </div>
            
            <div class="col-md-6" data-aos="fade-left">
                <div class="info-card h-100">
                    <h3 class="fw-bold mb-4">Derniers produits</h3>
                    <div class="row g-3">
                        <?php $__currentLoopData = \App\Models\Product::latest()->take(3)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-12">
                            <div class="d-flex align-items-center p-3 border rounded">
                                <?php if($product->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="rounded me-3" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                <?php elseif($product->images->count() > 0): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->images->first()->image_path)); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="rounded me-3" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1"><?php echo e($product->name); ?></h6>
                                    <p class="text-success fw-bold mb-0"><?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA</p>
                                </div>
                                <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary btn-modern w-100 mt-3">
                        <i class="fas fa-shopping-bag me-2"></i>Voir tout le catalogue
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Newsletter -->
    <div class="newsletter-section p-5" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="fw-bold mb-2">Restez informé !</h4>
                <p class="text-muted mb-0">Recevez nos dernières offres et nouveautés en vous inscrivant à notre newsletter.</p>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Votre email">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/home.blade.php ENDPATH**/ ?>