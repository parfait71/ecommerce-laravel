

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <?php if($product->images && $product->images->count() > 0): ?>
                <div id="productImagesCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="carousel-item <?php echo e($key === 0 ? 'active' : ''); ?>">
                                <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" class="d-block w-100" alt="<?php echo e($product->name); ?>" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;" onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php if($product->images->count() > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    <?php endif; ?>
                </div>
                <!-- Miniatures -->
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: contain; background-color: #f8f9fa; cursor: pointer; border: 2px solid #ddd;" data-bs-target="#productImagesCarousel" data-bs-slide-to="<?php echo e($key); ?>" <?php if($key === 0): ?> class="active" <?php endif; ?> alt="Miniature <?php echo e($product->name); ?>" onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php elseif($product->image): ?>
                <?php if(Str::startsWith($product->image, 'products/')): ?>
                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" class="img-fluid mb-3" alt="<?php echo e($product->name); ?>" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;" onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
                <?php else: ?>
                    <img src="<?php echo e(asset('images/' . $product->image)); ?>" class="img-fluid mb-3" alt="<?php echo e($product->name); ?>" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;" onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
                <?php endif; ?>
            <?php else: ?>
                <img src="<?php echo e(asset('images/default-product.png')); ?>" class="img-fluid mb-3" alt="Aucune image" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold mb-3"><?php echo e($product->name); ?></h2>
            <p class="mb-2"><?php echo e($product->description); ?></p>
            <p class="fw-bold fs-4 text-success mb-3"><?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA</p>
            
            
            <div class="mb-3">
                <?php if($product->stock > 0): ?>
                    <span class="badge bg-success fs-6">En stock (<?php echo e($product->stock); ?> disponibles)</span>
                <?php else: ?>
                    <span class="badge bg-danger fs-6">Rupture de stock</span>
                <?php endif; ?>
            </div>
            
            
            <div class="d-flex gap-2 mt-3">
                <?php if($product->stock > 0): ?>
                    <?php if(auth()->check() && auth()->user()->is_admin): ?>
                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle"></i> Les administrateurs ne peuvent pas passer de commandes</small>
                        </div>
                    <?php else: ?>
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-cart-plus"></i> Ajouter au panier
                            </button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-times"></i> Indisponible
                    </button>
                <?php endif; ?>
            </div>
            
            <div class="mt-3">
                <a href="<?php echo e(route('catalogue')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour au catalogue
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/products/show.blade.php ENDPATH**/ ?>