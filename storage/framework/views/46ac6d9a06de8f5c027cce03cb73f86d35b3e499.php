

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1>Mes commandes</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Mode de paiement</th>
                <th>Statut paiement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($order->id); ?></td>
                    <td><?php echo e($order->created_at); ?></td>
                    <td><?php echo e(number_format($order->total, 0, ',', ' ')); ?> FCFA</td>
                    <td><?php echo e($order->status); ?></td>
                    <td><?php echo e($order->payment ? $order->payment->method : 'N/A'); ?></td>
                    <td><?php echo e($order->payment ? $order->payment->status : 'N/A'); ?></td>
                    <td>
                        <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-sm btn-info">Voir</a>
                        <a href="<?php echo e(route('invoice.download', $order)); ?>" class="btn btn-sm btn-primary">Télécharger Facture</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7">Aucune commande trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/orders/index.blade.php ENDPATH**/ ?>