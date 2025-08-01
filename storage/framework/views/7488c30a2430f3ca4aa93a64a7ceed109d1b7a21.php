

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1>Détail de la commande #<?php echo e($order->order_number); ?></h1>
    
    <div class="mt-4">
        <a href="<?php echo e(route('invoice.view', $order)); ?>" 
           class="btn btn-primary" 
           target="_blank">
            Voir la Facture
        </a>
        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary ms-2">Retour à mes commandes</a>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/orders/show.blade.php ENDPATH**/ ?>