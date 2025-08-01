

<?php $__env->startSection('title', 'Gestion des commandes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Liste des commandes</h1>
        <a href="<?php echo e(route('admin.orders.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvelle commande
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>N° Commande</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Paiement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong>#<?php echo e($order->id); ?></strong>
                            </td>
                            <td>
                                <div>
                                    <strong><?php echo e($order->user->name ?? 'N/A'); ?></strong>
                                    <?php if($order->user): ?>
                                        <br><small class="text-muted"><?php echo e($order->user->email); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong><?php echo e($order->created_at->format('d/m/Y')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($order->created_at->format('H:i')); ?></small>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-success"><?php echo e(number_format($order->total, 0, ',', ' ')); ?> FCFA</span>
                            </td>
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
                            <td>
                                <?php if($order->payment): ?>
                                    <span class="badge <?php echo e($order->payment->status == 'payé' ? 'bg-success' : 'bg-warning'); ?>">
                                        <?php echo e(ucfirst($order->payment->status)); ?>

                                    </span>
                                    <?php if($order->payment->method): ?>
                                        <br><small class="text-muted"><?php echo e($order->payment->method); ?></small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Non défini</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-info btn-sm" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.orders.edit', $order)); ?>" class="btn btn-warning btn-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.orders.destroy', $order)); ?>" method="POST" style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                <p>Aucune commande trouvée.</p>
                                <a href="<?php echo e(route('admin.orders.create')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Créer la première commande
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($orders->hasPages()): ?>
                <div class="pagination-wrapper mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            <small class="text-muted">
                                Affichage de <?php echo e($orders->firstItem() ?? 0); ?> à <?php echo e($orders->lastItem() ?? 0); ?> 
                                sur <?php echo e($orders->total()); ?> résultat(s)
                            </small>
                        </div>
                        <nav aria-label="Navigation des pages">
                            <ul class="pagination pagination-modern mb-0">
                                
                                <?php if($orders->onFirstPage()): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($orders->previousPageUrl()); ?>" aria-label="Précédent">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                
                                <?php $__currentLoopData = $orders->getUrlRange(1, $orders->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($page == $orders->currentPage()): ?>
                                        <li class="page-item active">
                                            <span class="page-link"><?php echo e($page); ?></span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                
                                <?php if($orders->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($orders->nextPageUrl()); ?>" aria-label="Suivant">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>