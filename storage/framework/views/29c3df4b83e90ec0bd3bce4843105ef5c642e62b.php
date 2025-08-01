

<?php $__env->startSection('title', 'Gestion des utilisateurs'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Gestion des utilisateurs</h1>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvel utilisateur
        </a>
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
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div>
                                    <strong><?php echo e($user->name); ?></strong>
                                    <?php if($user->id === auth()->id()): ?>
                                        <span class="badge bg-info">Vous</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span><?php echo e($user->email); ?></span>
                                    <?php if($user->email_verified_at): ?>
                                        <br><small class="text-success"><i class="fas fa-check-circle"></i> Vérifié</small>
                                    <?php else: ?>
                                        <br><small class="text-warning"><i class="fas fa-exclamation-circle"></i> Non vérifié</small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php if($user->is_admin): ?>
                                    <span class="badge bg-danger">Administrateur</span>
                                <?php else: ?>
                                    <span class="badge bg-primary">Client</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div>
                                    <strong><?php echo e($user->created_at->format('d/m/Y')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($user->created_at->format('H:i')); ?></small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="btn btn-info btn-sm" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-warning btn-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <?php if($user->id !== auth()->id()): ?>
                                        <form action="<?php echo e(route('admin.users.toggleAdmin', $user)); ?>" method="POST" style="display:inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-<?php echo e($user->is_admin ? 'secondary' : 'success'); ?> btn-sm" title="<?php echo e($user->is_admin ? 'Retirer les droits admin' : 'Donner les droits admin'); ?>">
                                                <i class="fas fa-<?php echo e($user->is_admin ? 'user' : 'user-shield'); ?>"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="<?php echo e(route('admin.users.resetPassword', $user)); ?>" method="POST" style="display:inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-info btn-sm" title="Réinitialiser le mot de passe" 
                                                    onclick="return confirm('Réinitialiser le mot de passe de <?php echo e($user->name); ?> ?')">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" style="display:inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">Actions limitées</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <p>Aucun utilisateur trouvé.</p>
                                <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Créer le premier utilisateur
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($users->hasPages()): ?>
                <div class="pagination-wrapper mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            <small class="text-muted">
                                Affichage de <?php echo e($users->firstItem() ?? 0); ?> à <?php echo e($users->lastItem() ?? 0); ?> 
                                sur <?php echo e($users->total()); ?> résultat(s)
                            </small>
                        </div>
                        <nav aria-label="Navigation des pages">
                            <ul class="pagination pagination-modern mb-0">
                                
                                <?php if($users->onFirstPage()): ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                    </li>
                                <?php else: ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($users->previousPageUrl()); ?>" aria-label="Précédent">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                
                                <?php $__currentLoopData = $users->getUrlRange(1, $users->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($page == $users->currentPage()): ?>
                                        <li class="page-item active">
                                            <span class="page-link"><?php echo e($page); ?></span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                
                                <?php if($users->hasMorePages()): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo e($users->nextPageUrl()); ?>" aria-label="Suivant">
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/users/index.blade.php ENDPATH**/ ?>