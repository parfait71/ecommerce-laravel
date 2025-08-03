

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1>Détail de la commande #<?php echo e($order->id); ?></h1>
    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Date :</strong> <?php echo e($order->created_at); ?></li>
        <li class="list-group-item"><strong>Statut :</strong> <?php echo e($order->status ?? 'N/A'); ?></li>
        <li class="list-group-item"><strong>Total :</strong> <?php echo e(number_format($order->total, 0, ',', ' ')); ?> FCFA</li>
        <?php if($order->payment): ?>
            <li class="list-group-item"><strong>Mode de paiement :</strong> <?php echo e($order->payment->method); ?></li>
            <li class="list-group-item"><strong>Statut du paiement :</strong> <?php echo e($order->payment->status); ?></li>
        <?php endif; ?>
    </ul>
    <h4>Produits commandés</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->product->name ?? 'N/A'); ?></td>
                    <td><?php echo e($item->quantity); ?></td>
                    <td><?php echo e(number_format($item->price, 0, ',', ' ')); ?> FCFA</td>
                    <td><?php echo e(number_format($item->price * $item->quantity, 0, ',', ' ')); ?> FCFA</td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="mt-4">
        <a href="<?php echo e(route('invoice.download', $order)); ?>" class="btn btn-primary">Télécharger la facture PDF</a>
        <a href="<?php echo e(route('invoice.view', $order)); ?>" class="btn btn-secondary" target="_blank">Voir la facture</a>
        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary ms-2">Retour à mes commandes</a>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/orders/show.blade.php ENDPATH**/ ?>