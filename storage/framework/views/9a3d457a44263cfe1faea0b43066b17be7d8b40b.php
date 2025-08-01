

<?php $__env->startSection('title', 'Détails de l\'utilisateur'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Détails de l'utilisateur</h1>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations de l'utilisateur</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom :</strong> <?php echo e($user->name); ?></p>
                            <p><strong>Email :</strong> <?php echo e($user->email); ?></p>
                            <p><strong>Type :</strong> 
                                <?php if($user->is_admin): ?>
                                    <span class="badge bg-danger">Administrateur</span>
                                <?php else: ?>
                                    <span class="badge bg-primary">Client</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date d'inscription :</strong> <?php echo e($user->created_at->format('d/m/Y H:i')); ?></p>
                            <p><strong>Dernière connexion :</strong> <?php echo e($user->updated_at->format('d/m/Y H:i')); ?></p>
                            <p><strong>Email vérifié :</strong> 
                                <?php if($user->email_verified_at): ?>
                                    <span class="badge bg-success">Oui</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Non</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($user->orders && $user->orders->count() > 0): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Historique des commandes (<?php echo e($user->orders->count()); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $user->orders->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>#<?php echo e($order->id); ?></td>
                                    <td><?php echo e($order->created_at->format('d/m/Y')); ?></td>
                                    <td><?php echo e(number_format($order->total, 0, ',', ' ')); ?> FCFA</td>
                                    <td>
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
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($user->orders->count() > 5): ?>
                        <p class="text-muted mt-2">Affichage des 5 dernières commandes sur <?php echo e($user->orders->count()); ?> au total.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="card mb-4">
                <div class="card-body text-center text-muted">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <p>Aucune commande pour cet utilisateur.</p>
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
                    <?php if($user->id !== auth()->id()): ?>
                        <form action="<?php echo e(route('admin.users.toggleAdmin', $user)); ?>" method="POST" class="mb-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-<?php echo e($user->is_admin ? 'secondary' : 'success'); ?> btn-sm w-100">
                                <i class="fas fa-<?php echo e($user->is_admin ? 'user' : 'user-shield'); ?>"></i>
                                <?php echo e($user->is_admin ? 'Retirer les droits admin' : 'Donner les droits admin'); ?>

                            </button>
                        </form>
                        
                        <form action="<?php echo e(route('admin.users.resetPassword', $user)); ?>" method="POST" class="mb-3">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-info btn-sm w-100" 
                                    onclick="return confirm('Réinitialiser le mot de passe de <?php echo e($user->name); ?> ?')">
                                <i class="fas fa-key"></i> Réinitialiser le mot de passe
                            </button>
                        </form>
                        
                        <hr>
                        
                        <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash"></i> Supprimer l'utilisateur
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="text-muted text-center">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>Actions limitées pour votre propre compte.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Statistiques</h6>
                </div>
                <div class="card-body">
                    <p><strong>Total des commandes :</strong> <?php echo e($user->orders ? $user->orders->count() : 0); ?></p>
                    <p><strong>Montant total dépensé :</strong> 
                        <?php if($user->orders && $user->orders->count() > 0): ?>
                            <?php echo e(number_format($user->orders->sum('total'), 0, ',', ' ')); ?> FCFA
                        <?php else: ?>
                            0 FCFA
                        <?php endif; ?>
                    </p>
                    <p><strong>Client depuis :</strong> <?php echo e($user->created_at->diffForHumans()); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/users/show.blade.php ENDPATH**/ ?>