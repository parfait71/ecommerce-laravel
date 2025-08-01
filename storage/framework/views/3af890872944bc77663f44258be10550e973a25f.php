

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <?php if(auth()->guard()->guest()): ?>
        <div class="alert alert-warning">
            <h4>Connexion requise</h4>
            <p>Vous devez être connecté pour passer une commande.</p>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Se connecter</a>
        </div>
    <?php else: ?>
    <h1>Passer commande</h1>
    <form action="<?php echo e(route('orders.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label for="address" class="form-label">Adresse de livraison</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mode de paiement</label><br>
            <select name="payment_method" class="form-select" required>
                <option value="paiement en ligne">Paiement avant livraison (en ligne)</option>
                <option value="paiement à la livraison">Paiement à la livraison</option>
            </select>
        </div>
        <h4>Votre panier</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item['name']); ?></td>
                        <td><?php echo e($item['quantity']); ?></td>
                        <td><?php echo e(number_format($item['price'], 0, ',', ' ')); ?> FCFA</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="cart[<?php echo e($item['product_id']); ?>][product_id]" value="<?php echo e($item['product_id']); ?>">
            <input type="hidden" name="cart[<?php echo e($item['product_id']); ?>][quantity]" value="<?php echo e($item['quantity']); ?>">
            <input type="hidden" name="cart[<?php echo e($item['product_id']); ?>][price]" value="<?php echo e($item['price']); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <button type="submit" class="btn btn-primary mt-3">Valider la commande</button>
    </form>

    
    <form method="POST" action="<?php echo e(route('paiement.wave')); ?>" class="mt-3">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="amount" value="<?php echo e(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart))); ?>">
        <button type="submit" class="btn btn-info w-full flex items-center justify-center gap-2">
            <span>🌊</span> Payer en ligne avec Wave
        </button>
    </form>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="orders.store"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Formulaire soumis');
            console.log('Action:', this.action);
            console.log('Méthode:', this.method);
            
            // Afficher les données du formulaire
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key + ':', value);
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/checkout.blade.php ENDPATH**/ ?>