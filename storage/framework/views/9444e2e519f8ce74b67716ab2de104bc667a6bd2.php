

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1>Mon Panier</h1>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(count($cart) > 0): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Stock disponible</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productId => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $total += $item['price'] * $item['quantity'];
                            $product = \App\Models\Product::find($productId);
                        ?>
                        <tr>
                            <td><?php echo e($item['name']); ?></td>
                            <td><?php echo e(number_format($item['price'], 0, ',', ' ')); ?> FCFA</td>
                            <td>
                                <?php if($product && $product->stock > 0): ?>
                                    <span class="badge bg-success"><?php echo e($product->stock); ?> disponibles</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rupture</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="<?php echo e(route('cart.update')); ?>" method="POST" style="display:inline-block;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                    <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1" max="<?php echo e($product ? $product->stock : 1); ?>" style="width: 60px;">
                                    <button type="submit" class="btn btn-sm btn-warning">Mettre à jour</button>
                                </form>
                            </td>
                            <td><?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', ' ')); ?> FCFA</td>
                            <td>
                                <form action="<?php echo e(route('cart.remove')); ?>" method="POST" style="display:inline-block;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($productId); ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total :</strong></td>
                        <td><strong><?php echo e(number_format($total, 0, ',', ' ')); ?> FCFA</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><span>Frais de Livraison :</span></td>
                        <td><span class="text-primary fw-bold"><?php echo e($total >= 50000 ? 'Offerts' : '2 000 FCFA'); ?></span></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="d-flex flex-wrap justify-content-center gap-3 mt-5">
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary flex-fill" style="min-width:180px;">Continuer mes achats</a>
            <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="mb-0 flex-fill" style="min-width:180px;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-secondary w-100">Vider le panier</button>
            </form>
            <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary flex-fill" style="min-width:180px;">Passer commande</a>
        </div>
        <div class="mt-5 p-4 rounded shadow-sm text-center mx-auto" style="background:#f8fafc; max-width:600px;">
            <div class="d-flex flex-wrap justify-content-center gap-4 fs-5">
                <div><span style="font-size:2rem;">🚚</span><br><strong>Livraison rapide</strong></div>
                <div><span style="font-size:2rem;">🔄</span><br><strong>Retours faciles</strong></div>
                <div><span style="font-size:2rem;">🔒</span><br><strong>Paiement sécurisé</strong></div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center mt-5">
            <h3>Votre panier est vide</h3>
            <p>Ajoutez des produits depuis le catalogue pour commencer vos achats.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">Voir le catalogue</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/cart.blade.php ENDPATH**/ ?>