

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="mb-4 text-primary text-center fw-bold">Catalogue des produits</h1>
    
    <!-- Formulaire de recherche et filtrage -->
    <form method="GET" action="" class="row g-3 mb-4 align-items-end">
        <div class="col-md-3">
            <label for="keyword" class="form-label">Recherche</label>
            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Nom ou description..." value="<?php echo e(request('keyword')); ?>">
        </div>
        <div class="col-md-2">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" class="form-select">
                <option value="">Toutes les catégories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="min_price" class="form-label">Prix min</label>
            <input type="number" name="min_price" id="min_price" class="form-control" placeholder="0" min="0" value="<?php echo e(request('min_price')); ?>">
        </div>
        <div class="col-md-2">
            <label for="max_price" class="form-label">Prix max</label>
            <input type="number" name="max_price" id="max_price" class="form-control" placeholder="100000" min="0" value="<?php echo e(request('max_price')); ?>">
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="in_stock" id="in_stock" value="1" <?php echo e(request('in_stock') ? 'checked' : ''); ?>>
                <label class="form-check-label" for="in_stock">
                    En stock seulement
                </label>
            </div>
        </div>
        <div class="col-md-2">
            <label for="sort" class="form-label">Trier par</label>
            <select name="sort" id="sort" class="form-select">
                <option value="">Par défaut</option>
                <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Prix croissant</option>
                <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Prix décroissant</option>
                <option value="name_asc" <?php echo e(request('sort') == 'name_asc' ? 'selected' : ''); ?>>Nom A-Z</option>
                <option value="name_desc" <?php echo e(request('sort') == 'name_desc' ? 'selected' : ''); ?>>Nom Z-A</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold whitespace-nowrap">
                Rechercher
            </button>
        </div>
    </form>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col animate-fade-in-up" style="animation-delay: <?php echo e($loop->index * 0.1); ?>s;">
                <div class="card h-100 shadow-sm">
                    <?php if($product->image): ?>
                        <?php if(Str::startsWith($product->image, 'products/')): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>" style="height: 220px; object-fit: contain; background-color: #f8f9fa; border-top-left-radius: .5rem; border-top-right-radius: .5rem;" onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/' . $product->image)); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>" style="height: 220px; object-fit: contain; background-color: #f8f9fa; border-top-left-radius: .5rem; border-top-right-radius: .5rem;" onerror="this.src='<?php echo e(asset('images/default-product.png')); ?>'">
                        <?php endif; ?>
                    <?php else: ?>
                        <img src="<?php echo e(asset('images/default-product.png')); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>" style="height: 220px; object-fit: contain; background-color: #f8f9fa; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?php echo e($product->name); ?></h5>
                        <p class="card-text text-muted"><?php echo e($product->description); ?></p>
                        <div class="mt-auto">
                            <p class="text-success fw-bold fs-5 mb-2"><?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA</p>
                            
                            
                            <div class="mb-2">
                                <?php if($product->stock > 0): ?>
                                    <span class="badge bg-success">En stock (<?php echo e($product->stock); ?>)</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rupture de stock</span>
                                <?php endif; ?>
                            </div>
                            
                            
                            <?php if($product->stock > 0): ?>
                                <?php if(auth()->check() && auth()->user()->is_admin): ?>
                                    <div class="alert alert-info mb-2">
                                        <small><i class="fas fa-info-circle"></i> Les administrateurs ne peuvent pas passer de commandes</small>
                                    </div>
                                <?php else: ?>
                                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-success btn-sm me-2">
                                            <i class="fas fa-cart-plus"></i> Ajouter au panier
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm me-2" disabled>
                                    <i class="fas fa-times"></i> Indisponible
                                </button>
                            <?php endif; ?>
                            
                            <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-info btn-sm">Voir</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center text-muted">Aucun produit disponible.</div>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <?php if($products->hasPages()): ?>
        <div class="d-flex justify-content-center my-5">
            <nav aria-label="Navigation des pages" class="custom-pagination">
                <ul class="pagination pagination-lg mb-0">
                    
                    <?php if($products->onFirstPage()): ?>
                        <li class="page-item disabled">
                            <span class="page-link bg-light text-muted border-0 rounded-start">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link bg-primary text-white border-0 rounded-start" href="<?php echo e($products->previousPageUrl()); ?>" rel="prev">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $products->getUrlRange(1, $products->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $products->currentPage()): ?>
                            <li class="page-item active">
                                <span class="page-link bg-success border-0 fw-bold"><?php echo e($page); ?></span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link bg-light text-dark border-0" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($products->hasMorePages()): ?>
                        <li class="page-item">
                            <a class="page-link bg-primary text-white border-0 rounded-end" href="<?php echo e($products->nextPageUrl()); ?>" rel="next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link bg-light text-muted border-0 rounded-end">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        
        <style>
            .custom-pagination .pagination {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 50px;
                overflow: hidden;
            }
            .custom-pagination .page-link {
                padding: 12px 16px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .custom-pagination .page-link:hover {
                transform: translateY(-2px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }
            .custom-pagination .page-item.active .page-link {
                background: linear-gradient(45deg, #28a745, #20c997);
                border: none;
            }
            .custom-pagination .page-item:not(.active) .page-link {
                background: #f8f9fa;
                color: #495057;
            }
            .custom-pagination .page-item:not(.active) .page-link:hover {
                background: #e9ecef;
                color: #212529;
            }
        </style>
    <?php endif; ?>
    
    <div class="text-center mt-4">
        <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i> Voir mon panier
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/catalogue.blade.php ENDPATH**/ ?>