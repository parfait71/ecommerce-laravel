

<?php $__env->startSection('title', 'Détails de la catégorie'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Détails de la catégorie</h1>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-secondary">
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
                    <h5 class="mb-0">Informations de la catégorie</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom :</strong> <?php echo e($category->name); ?></p>
                            <p><strong>Slug :</strong> <code><?php echo e($category->formatted_slug); ?></code></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date de création :</strong> <?php echo e($category->formatted_created_at); ?></p>
                            <p><strong>Dernière modification :</strong> <?php echo e($category->formatted_updated_at); ?></p>
                        </div>
                    </div>
                    
                    <?php if($category->description): ?>
                    <div class="mt-3">
                        <strong>Description :</strong>
                        <p class="mt-2"><?php echo e($category->description); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($category->products && $category->products->count() > 0): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Produits de cette catégorie (<?php echo e($category->products->count()); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $category->products->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div>
                                            <strong><?php echo e($product->name); ?></strong>
                                            <?php if($product->description): ?>
                                                <br><small class="text-muted"><?php echo e(Str::limit($product->description, 50)); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA</td>
                                    <td>
                                        <?php if($product->stock > 0): ?>
                                            <span class="badge bg-success"><?php echo e($product->stock); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Rupture</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($category->products->count() > 10): ?>
                        <p class="text-muted mt-2">Affichage des 10 premiers produits sur <?php echo e($category->products->count()); ?> au total.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="card mb-4">
                <div class="card-body text-center text-muted">
                    <i class="fas fa-box fa-3x mb-3"></i>
                    <p>Aucun produit dans cette catégorie.</p>
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
                    <a href="<?php echo e(route('admin.products.create')); ?>?category_id=<?php echo e($category->id); ?>" class="btn btn-success btn-sm w-100 mb-2">
                        <i class="fas fa-plus"></i> Ajouter un produit
                    </a>
                    
                    <hr>
                    
                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash"></i> Supprimer la catégorie
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Statistiques</h6>
                </div>
                <div class="card-body">
                    <p><strong>Total des produits :</strong> <?php echo e($category->products ? $category->products->count() : 0); ?></p>
                    <p><strong>Produits en stock :</strong> 
                        <?php if($category->products): ?>
                            <?php echo e($category->products->where('stock', '>', 0)->count()); ?>

                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </p>
                    <p><strong>Produits en rupture :</strong> 
                        <?php if($category->products): ?>
                            <?php echo e($category->products->where('stock', 0)->count()); ?>

                        <?php else: ?>
                            0
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/categories/show.blade.php ENDPATH**/ ?>