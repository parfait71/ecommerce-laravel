

<?php $__env->startSection('header'); ?>
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-5 fw-bold mb-3">
            <i class="fas fa-credit-card me-3"></i>Finaliser la commande
        </h1>
        <p class="lead mb-0">Récapitulatif et paiement sécurisé</p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-5">
        <!-- Formulaire de commande -->
        <div class="col-lg-8" data-aos="fade-right">
            <div class="contact-section">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-shipping-fast me-2"></i>Informations de livraison
                </h4>
                
                <form action="<?php echo e(route('orders.store')); ?>" method="POST" id="checkoutForm">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Informations personnelles -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Prénom</label>
                            <input type="text" class="form-control" value="<?php echo e(Auth::user()->name); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" value="<?php echo e(Auth::user()->email); ?>" readonly>
                        </div>
                    </div>

                    <!-- Adresse de livraison -->
                    <div class="mb-4">
                        <label for="address" class="form-label fw-bold">
                            <i class="fas fa-map-marker-alt me-2"></i>Adresse de livraison complète
                        </label>
                        <textarea name="address" id="address" class="form-control" rows="3" 
                                  placeholder="Entrez votre adresse complète (rue, ville, code postal)" required></textarea>
                        <small class="text-muted">Cette adresse sera utilisée pour la livraison de votre commande.</small>
                    </div>

                    <!-- Mode de paiement -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-credit-card me-2"></i>Mode de paiement
                        </label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="online" value="paiement en ligne" class="form-check-input" checked>
                                    <label for="online" class="form-check-label w-100 p-3 border rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-lock text-success me-3"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">Paiement sécurisé</h6>
                                                <small class="text-muted">Wave, Orange Money, Virement</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="delivery" value="paiement à la livraison" class="form-check-input">
                                    <label for="delivery" class="form-check-label w-100 p-3 border rounded">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-truck text-primary me-3"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">Paiement à la livraison</h6>
                                                <small class="text-muted">Payez quand vous recevez</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations cachées du panier -->
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="cart[<?php echo e($loop->index); ?>][product_id]" value="<?php echo e($item['product_id']); ?>">
                        <input type="hidden" name="cart[<?php echo e($loop->index); ?>][quantity]" value="<?php echo e($item['quantity']); ?>">
                        <input type="hidden" name="cart[<?php echo e($loop->index); ?>][price]" value="<?php echo e($item['price']); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </form>
            </div>

            <!-- Informations de sécurité -->
            <div class="info-card mt-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-shield-alt me-2"></i>Paiement sécurisé
                </h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lock text-success me-2"></i>
                            <small>Données cryptées</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <small>Protection SSL</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Garantie 100%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Résumé de commande -->
        <div class="col-lg-4" data-aos="fade-left">
            <div class="info-card sticky-top" style="top: 20px;">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-receipt me-2"></i>Récapitulatif
                </h4>

                <!-- Produits -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Vos articles (<?php echo e(count($cart)); ?>)</h6>
                    <?php $total = 0; ?>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $total += $item['price'] * $item['quantity']; ?>
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <img src="<?php echo e(asset('images/products/' . ($item['image'] ?? 'default.jpg'))); ?>" 
                                 class="rounded me-3" 
                                 alt="<?php echo e($item['name']); ?>"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1"><?php echo e($item['name']); ?></h6>
                                <small class="text-muted">Quantité: <?php echo e($item['quantity']); ?></small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold"><?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', ' ')); ?> FCFA</span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Calculs -->
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total</span>
                        <span><?php echo e(number_format($total, 0, ',', ' ')); ?> FCFA</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Livraison</span>
                        <span class="text-success">Gratuite</span>
                    </div>
                    <?php if($total < 10000): ?>
                        <div class="alert alert-warning small mb-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Ajoutez <?php echo e(number_format(10000 - $total, 0, ',', ' ')); ?> FCFA pour la livraison gratuite !
                        </div>
                    <?php endif; ?>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-success"><?php echo e(number_format($total, 0, ',', ' ')); ?> FCFA</span>
                    </div>
                </div>

                <!-- Bouton de validation -->
                <button type="submit" form="checkoutForm" class="btn btn-primary btn-modern w-100 mb-3" id="submitOrder">
                    <i class="fas fa-credit-card me-2"></i>Confirmer la commande
                </button>

                <div class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-lock me-1"></i>
                        Vos données sont protégées
                    </small>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('submitOrder');
    
    // Validation du formulaire
    form.addEventListener('submit', function(e) {
        const address = document.getElementById('address').value.trim();
        
        if (!address) {
            e.preventDefault();
            alert('Veuillez saisir votre adresse de livraison.');
            return;
        }
        
        // Animation de chargement
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement en cours...';
        submitBtn.disabled = true;
    });
    
    // Styles pour les options de paiement
    document.querySelectorAll('.payment-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Retirer la classe active de tous les labels
            document.querySelectorAll('.payment-option label').forEach(label => {
                label.classList.remove('border-primary', 'bg-primary', 'text-white');
                label.classList.add('border');
            });
            
            // Ajouter la classe active au label sélectionné
            if (this.checked) {
                this.nextElementSibling.classList.remove('border');
                this.nextElementSibling.classList.add('border-primary', 'bg-primary', 'text-white');
            }
        });
    });
    
    // Initialiser le premier radio button
    document.querySelector('.payment-option input[type="radio"]:checked').dispatchEvent(new Event('change'));
});
</script>

<style>
.payment-option input[type="radio"] {
    display: none;
}

.payment-option label {
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-option label:hover {
    border-color: var(--primary-color) !important;
    background-color: rgba(37, 99, 235, 0.1) !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/checkout.blade.php ENDPATH**/ ?>