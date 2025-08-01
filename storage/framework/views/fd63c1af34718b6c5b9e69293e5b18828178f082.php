<?php $__env->startSection('header'); ?>
    <h2 class="text-center text-primary fw-bold fs-3">
        Dashboard
    </h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="py-4 bg-light">
        <div class="container">
            <div class="card shadow border-0">
                <div class="card-body">

                    <?php if(Auth::check()): ?>
                        <div class="mb-4">
                            <h5 class="fw-bold">Informations Utilisateur</h5>
                            <p><strong>Email :</strong> <?php echo e(Auth::user()->email); ?></p>
                            <p><strong>Rôle :</strong> <?php echo e(Auth::user()->is_admin ? 'ADMIN' : 'CLIENT'); ?></p>
                        </div>
                    <?php endif; ?>

                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary mb-3">
                        Accéder au catalogue
                    </a>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="<?php echo e(route('about')); ?>" class="btn btn-outline-info">À propos</a>
                        <a href="<?php echo e(route('mentions-legales')); ?>" class="btn btn-outline-secondary">Mentions légales</a>
                        <a href="<?php echo e(route('politique-confidentialite')); ?>" class="btn btn-outline-primary">Politique de confidentialité</a>
                        <a href="<?php echo e(route('cgv')); ?>" class="btn btn-outline-success">CGV</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/dashboard.blade.php ENDPATH**/ ?>