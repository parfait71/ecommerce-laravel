

<?php $__env->startSection('title', 'Détails de la commande'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Détails de la commande #<?php echo e($order->id); ?></h1>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.orders.edit', $order)); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations de la commande</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>N° Commande :</strong> #<?php echo e($order->id); ?></p>
                            <p><strong>Date de création :</strong> <?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                            <p><strong>Dernière modification :</strong> <?php echo e($order->updated_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Statut :</strong> 
                                <?php switch($order->status):
                                    case ('livrée'): ?>
                                        <span class="badge bg-success"><?php echo e(ucfirst($order->status)); ?></span>
                                        <?php break; ?>
                                    <?php case ('expédiée'): ?>
                                        <span class="badge bg-info"><?php echo e(ucfirst($order->status)); ?></span>
                                        <?php break; ?>
                                    <?php case ('annulée'): ?>
                                        <span class="badge bg-danger"><?php echo e(ucfirst($order->status)); ?></span>
                                        <?php break; ?>
                                    <?php default: ?>
                                        <span class="badge bg-warning"><?php echo e(ucfirst($order->status)); ?></span>
                                <?php endswitch; ?>
                            </p>
                            <p><strong>Montant total :</strong> <span class="fw-bold text-success"><?php echo e(number_format($order->total, 0, ',', ' ')); ?> FCFA</span></p>
                            <?php if($order->notes): ?>
                                <p><strong>Notes :</strong> <?php echo e($order->notes); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($order->user): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations client</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom :</strong> <?php echo e($order->user->name); ?></p>
                            <p><strong>Email :</strong> <?php echo e($order->user->email); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date d'inscription :</strong> <?php echo e($order->user->created_at->format('d/m/Y')); ?></p>
                            <p><strong>Type :</strong> 
                                <?php if($order->user->is_admin): ?>
                                    <span class="badge bg-danger">Administrateur</span>
                                <?php else: ?>
                                    <span class="badge bg-primary">Client</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if($order->payment): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations de paiement</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Méthode :</strong> <?php echo e($order->payment->method ?? 'Non spécifié'); ?></p>
                            <p><strong>Statut :</strong> 
                                <span class="badge <?php echo e($order->payment->status == 'payé' ? 'bg-success' : 'bg-warning'); ?>">
                                    <?php echo e(ucfirst($order->payment->status)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <?php if($order->payment->transaction_id): ?>
                                <p><strong>ID Transaction :</strong> <?php echo e($order->payment->transaction_id); ?></p>
                            <?php endif; ?>
                            <?php if($order->payment->paid_at): ?>
                                <p><strong>Payé le :</strong> <?php echo e($order->payment->paid_at->format('d/m/Y H:i')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" method="POST" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="status" class="form-label">Changer le statut</label>
                            <select name="status" id="status" class="form-select">
                                <option value="en attente" <?php echo e($order->status == 'en attente' ? 'selected' : ''); ?>>En attente</option>
                                <option value="expédiée" <?php echo e($order->status == 'expédiée' ? 'selected' : ''); ?>>Expédiée</option>
                                <option value="livrée" <?php echo e($order->status == 'livrée' ? 'selected' : ''); ?>>Livrée</option>
                                <option value="annulée" <?php echo e($order->status == 'annulée' ? 'selected' : ''); ?>>Annulée</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                    </form>

                    <?php if($order->payment): ?>
                    <form action="<?php echo e(route('admin.orders.updatePaymentStatus', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Changer le statut de paiement</label>
                            <select name="payment_status" id="payment_status" class="form-select">
                                <option value="non payé" <?php echo e($order->payment->status == 'non payé' ? 'selected' : ''); ?>>Non payé</option>
                                <option value="en attente" <?php echo e($order->payment->status == 'en attente' ? 'selected' : ''); ?>>En attente</option>
                                <option value="payé" <?php echo e($order->payment->status == 'payé' ? 'selected' : ''); ?>>Payé</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-credit-card"></i> Mettre à jour
                        </button>
                    </form>
                    <?php endif; ?>

                    <hr>

                    <form action="<?php echo e(route('admin.orders.destroy', $order)); ?>" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash"></i> Supprimer la commande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>