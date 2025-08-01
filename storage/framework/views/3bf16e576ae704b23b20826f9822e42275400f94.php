<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title'); ?> - Admin | EazyStore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-pagination.css')); ?>">
</head>
<body>

    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>">
                <img src="<?php echo e(asset('images/admin-logo.svg')); ?>" alt="EazyStore Admin" height="30" class="d-inline-block align-text-top me-2">
                <span class="d-none d-sm-inline">EazyStore Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
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

    
    <?php echo $__env->yieldContent('content'); ?>
    
    
    <?php if(session('error')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/layouts/admin.blade.php ENDPATH**/ ?>