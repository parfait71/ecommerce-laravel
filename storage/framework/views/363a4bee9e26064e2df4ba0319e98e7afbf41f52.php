

<?php $__env->startSection('title', 'Gestion des produits'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des produits</h2>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un produit
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
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php if($product->image): ?>
                                    <?php if(Str::startsWith($product->image, 'products/')): ?>
                                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                             alt="<?php echo e($product->name); ?>" 
                                             width="60" 
                                             height="60" 
                                             style="object-fit: contain; background-color: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;"
                                             onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('images/' . $product->image)); ?>" 
                                             alt="<?php echo e($product->name); ?>" 
                                             width="60" 
                                             height="60" 
                                             style="object-fit: contain; background-color: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;"
                                             onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
                                    <?php endif; ?>
                                <?php else: ?>
                                    <img src="<?php echo e(asset('images/default-product.png')); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         width="60" 
                                         height="60" 
                                         style="object-fit: contain; background-color: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e($product->name); ?></strong>
                                <?php if($product->description): ?>
                                    <br><small class="text-muted"><?php echo e(Str::limit($product->description, 50)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($product->category): ?>
                                    <span class="badge bg-info"><?php echo e($product->category->name); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-bold text-success"><?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA</span>
                            </td>
                            <td>
                                <?php if($product->stock > 0): ?>
                                    <span class="badge bg-success"><?php echo e($product->stock); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rupture</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="btn btn-info btn-sm" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-warning btn-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <i class="fas fa-box fa-3x mb-3"></i>
                                <p>Aucun produit trouvé.</p>
                                <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Ajouter le premier produit
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($products->hasPages()): ?>
                <div class="pagination-wrapper mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            <small class="text-muted">
                                Affichage de <?php echo e($products->firstItem() ?? 0); ?> à <?php echo e($products->lastItem() ?? 0); ?> 
                                sur <?php echo e($products->total()); ?> résultat(s)
                            </small>
                        </div>
                        <nav aria-label="Navigation des pages">
                            <ul class="pagination pagination-modern mb-0">
                                
                                <?php if($products->onFirstPage()): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($products->previousPageUrl()); ?>" aria-label="Précédent">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                
                                <?php $__currentLoopData = $products->getUrlRange(1, $products->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($page == $products->currentPage()): ?>
                                        <li class="page-item active">
                                            <span class="page-link"><?php echo e($page); ?></span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                
                                <?php if($products->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($products->nextPageUrl()); ?>" aria-label="Suivant">
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/products/index.blade.php ENDPATH**/ ?>