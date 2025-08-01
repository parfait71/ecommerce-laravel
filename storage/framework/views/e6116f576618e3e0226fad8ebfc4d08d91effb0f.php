

<?php $__env->startSection('title', 'Détails du produit'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Détails du produit</h3>
                    <div>
                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Informations générales</h4>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">ID :</th>
                                    <td><?php echo e($product->id); ?></td>
                                </tr>
                                <tr>
                                    <th>Nom :</th>
                                    <td><?php echo e($product->name); ?></td>
                                </tr>
                                <tr>
                                    <th>Description :</th>
                                    <td><?php echo e($product->description); ?></td>
                                </tr>
                                <tr>
                                    <th>Prix :</th>
                                    <td><?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA</td>
                                </tr>
                                <tr>
                                    <th>Stock :</th>
                                    <td>
                                        <span class="badge <?php echo e($product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger')); ?>">
                                            <?php echo e($product->stock); ?> unités
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Catégorie :</th>
                                    <td>
                                        <?php if($product->category): ?>
                                            <span class="badge bg-info"><?php echo e($product->category->name); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Aucune catégorie</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Statut :</th>
                                    <td>
                                        <span class="badge <?php echo e($product->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                                            <?php echo e($product->is_active ? 'Actif' : 'Inactif'); ?>

                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Créé le :</th>
                                    <td><?php echo e($product->created_at ? $product->created_at->format('d/m/Y à H:i') : 'Non spécifié'); ?></td>
                                </tr>
                                <tr>
                                    <th>Modifié le :</th>
                                    <td><?php echo e($product->updated_at ? $product->updated_at->format('d/m/Y à H:i') : 'Non spécifié'); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Image du produit</h4>
                            <?php if($product->image): ?>
                                <div class="text-center">
                                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 300px;">
                                </div>
                            <?php else: ?>
                                <div class="text-center text-muted">
                                    <i class="fas fa-image fa-3x mb-3"></i>
                                    <p>Aucune image</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($product->productImages && $product->productImages->count() > 0): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Images supplémentaires</h4>
                            <div class="row">
                                <?php $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card">
                                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" 
                                             alt="Image <?php echo e($loop->iteration); ?>" 
                                             class="card-img-top" 
                                             style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <small class="text-muted">Image <?php echo e($loop->iteration); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Actions</h4>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-list"></i> Liste des produits
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/products/show.blade.php ENDPATH**/ ?>