

<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <h1 class="mb-4">Tableau de bord</h1>

    <!-- Statistiques générales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Chiffre d'affaires total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($totalRevenue, 0, ',', ' ')); ?> FCFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Commandes totales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalOrders); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Produits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalProducts); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Clients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalUsers); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques du mois -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                CA du mois</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($monthlyRevenue, 0, ',', ' ')); ?> FCFA
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Commandes du mois</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($monthlyOrders); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Commandes de la semaine</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($weeklyOrders); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Produits en rupture</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($outOfStockProducts); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et tableaux -->
    <div class="row">
        <!-- Produits les plus vendus -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produits les plus vendus</h6>
                </div>
                <div class="card-body">
                    <?php if($topProducts->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Quantité vendue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($product->name); ?></td>
                                        <td><?php echo e($product->total_sold); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Aucune vente enregistrée</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Commandes par statut -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Commandes par statut</h6>
                </div>
                <div class="card-body">
                    <?php if($ordersByStatus->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Statut</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $ordersByStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(ucfirst($status->status)); ?></td>
                                        <td><?php echo e($status->count); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Aucune commande</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Commandes récentes -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Commandes récentes</h6>
                </div>
                <div class="card-body">
                    <?php if($recentOrders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Client</th>
                                        <th>Total</th>
                                        <th>Statut</th>
                                        <th>Paiement</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>#<?php echo e($order->id); ?></td>
                                        <td><?php echo e($order->user->name); ?></td>
                                        <td><?php echo e(number_format($order->total, 0, ',', ' ')); ?> FCFA</td>
                                        <td>
                                            <span class="badge badge-<?php echo e($order->status == 'livrée' ? 'success' : ($order->status == 'expédiée' ? 'info' : 'warning')); ?>">
                                                <?php echo e(ucfirst($order->status)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if($order->payment): ?>
                                                <span class="badge badge-<?php echo e($order->payment->status == 'payé' ? 'success' : 'warning'); ?>">
                                                    <?php echo e(ucfirst($order->payment->status)); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Non défini</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Aucune commande récente</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits en rupture de stock -->
    <?php if($outOfStockProductsList->count() > 0): ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Produits en rupture de stock</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $outOfStockProductsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($product->name); ?></td>
                                    <td><?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA</td>
                                    <td>
                                        <span class="badge badge-danger"><?php echo e($product->stock); ?></span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}
.text-xs {
    font-size: 0.7rem;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>