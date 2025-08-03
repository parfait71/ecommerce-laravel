<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title'); ?> - Admin | EazyStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>">EazyStore Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.analytics.dashboard')); ?>">Analytics</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.products.index')); ?>">Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.orders.index')); ?>">Commandes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.users.index')); ?>">Utilisateurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.categories.index')); ?>">Catégories</a></li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><span class="nav-link"><?php echo e(Auth::user()->name); ?></span></li>
                    <li class="nav-item">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-sm btn-outline-light" type="submit">Se déconnecter</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    
    <div class="container-fluid mt-4">
        <?php echo $__env->yieldContent('header'); ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    
    <?php echo $__env->yieldPushContent('scripts'); ?>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/layouts/admin.blade.php ENDPATH**/ ?>