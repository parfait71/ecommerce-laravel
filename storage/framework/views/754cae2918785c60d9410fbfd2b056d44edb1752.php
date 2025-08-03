

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="mb-4 text-primary text-center fw-bold">Catalogue des produits</h1>
    
    <!-- Formulaire de recherche et filtrage -->
    <form method="GET" action="" class="row g-3 mb-4 align-items-end">
        <div class="col-md-5">
            <label for="keyword" class="form-label">Recherche</label>
            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Nom ou description..." value="<?php echo e(request('keyword')); ?>">
        </div>
        <div class="col-md-4">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" class="form-select">
                <option value="">Toutes les catégories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </div>
    </form>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow border rounded bg-white">
            <thead class="table-primary">
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col" class="text-end">Prix</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <th scope="row" class="text-center"><?php echo e($product->id); ?></th>
                        <td class="fw-bold"><?php echo e($product->name); ?></td>
                        <td><?php echo e($product->description); ?></td>
                        <td class="text-success fw-bold text-end" style="font-size:1.1em;">
                            <?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA
                        </td>
                        <td class="text-center">
                            <form action="<?php echo e(route('cart.add')); ?>" method="POST" style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-cart-plus"></i> Ajouter au panier
                                </button>
                            </form>
                            <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-info btn-sm ms-2">Voir</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Aucun produit disponible.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($products->hasPages()): ?>
        <div class="d-flex justify-content-center my-4">
            <?php echo e($products->links()); ?>

        </div>
    <?php endif; ?>
    <div class="text-center mt-4">
        <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i> Voir mon panier
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/catalogue.blade.php ENDPATH**/ ?>