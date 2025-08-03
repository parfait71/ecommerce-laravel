<nav x-data="{ open: false }" class="navbar-custom navbar-expand-lg">
    <div class="container">
        <div class="navbar-brand d-flex align-items-center">
            <a href="<?php echo e(Auth::check() && Auth::user()->is_admin ? route('admin.dashboard') : route('home')); ?>" class="text-white text-decoration-none">
                <i class="fas fa-store me-3 text-white"></i>
                <span class="fw-bold fs-3 text-white">EazyStore</span>
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white px-3 py-2" href="<?php echo e(route('home')); ?>">
                        <i class="fas fa-home me-2"></i>Accueil
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link text-white px-3 py-2" href="<?php echo e(route('products.index')); ?>">
                        <i class="fas fa-shopping-bag me-2"></i>Catalogue
                    </a>
                </li>
                
                <?php if(auth()->guard()->check()): ?>
                    <?php if(!Auth::user()->is_admin): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white px-3 py-2" href="<?php echo e(route('cart.index')); ?>">
                                <i class="fas fa-shopping-cart me-2"></i>Panier
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link text-white px-3 py-2" href="<?php echo e(route('orders.index')); ?>">
                                <i class="fas fa-list me-2"></i>Mes commandes
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav">
                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white px-3 py-2" href="<?php echo e(route('login')); ?>">
                            <i class="fas fa-sign-in-alt me-2"></i>Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white px-3 py-2" href="<?php echo e(route('register')); ?>">
                            <i class="fas fa-user-plus me-2"></i>Inscription
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white px-3 py-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i><?php echo e(Auth::user()->name); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                                    <i class="fas fa-user me-2"></i>Mon profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo e(route('analytics.dashboard')); ?>">
                                    <i class="fas fa-chart-line me-2"></i>Mon tableau de bord
                                </a>
                            </li>
                            <?php if(Auth::user()->is_admin): ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt me-2"></i>Administration
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>