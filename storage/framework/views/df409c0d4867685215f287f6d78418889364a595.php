

<?php $__env->startSection('header'); ?>
    <div class="page-header" data-aos="fade-up">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">
                    <i class="fas fa-user-edit me-3"></i>Modifier l'utilisateur
                </h1>
                <p class="page-subtitle">Modifiez les informations de <?php echo e($user->name); ?></p>
            </div>
            <div class="header-right">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="back-btn">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-modern" role="alert" data-aos="fade-up">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-modern" role="alert" data-aos="fade-up">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="edit-container" data-aos="fade-up">
        <div class="edit-card">
            <div class="user-preview">
                <div class="user-avatar-large">
                    <img src="<?php echo e(asset('images/avatar.png')); ?>" alt="<?php echo e($user->name); ?>" class="avatar-img-large">
                    <?php if($user->is_admin): ?>
                        <div class="admin-badge-large">
                            <i class="fas fa-crown"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="user-info-preview">
                    <h3 class="user-name-large"><?php echo e($user->name); ?></h3>
                    <p class="user-email-large"><?php echo e($user->email); ?></p>
                    <div class="user-status-large">
                        <span class="status-dot-large <?php echo e($user->is_admin ? 'admin' : 'user'); ?>"></span>
                        <span class="status-text-large"><?php echo e($user->is_admin ? 'Administrateur' : 'Utilisateur'); ?></span>
                    </div>
                </div>
            </div>

            <form action="<?php echo e(route('admin.users.update', $user)); ?>" method="POST" class="edit-form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-user me-2"></i>Informations personnelles
                    </h4>
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Nom complet</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?php echo e(old('name', $user->name)); ?>" 
                               class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Entrez le nom complet">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="<?php echo e(old('email', $user->email)); ?>" 
                               class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Entrez l'adresse email">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-shield-alt me-2"></i>Permissions
                    </h4>
                    
                    <div class="form-group">
                        <label class="form-label">Rôle utilisateur</label>
                        <div class="role-options">
                            <div class="role-option">
                                <input type="radio" 
                                       id="role_user" 
                                       name="is_admin" 
                                       value="0" 
                                       <?php echo e(!$user->is_admin ? 'checked' : ''); ?>

                                       class="role-input">
                                <label for="role_user" class="role-label">
                                    <div class="role-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="role-info">
                                        <span class="role-name">Utilisateur</span>
                                        <span class="role-description">Accès limité aux fonctionnalités client</span>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="role-option">
                                <input type="radio" 
                                       id="role_admin" 
                                       name="is_admin" 
                                       value="1" 
                                       <?php echo e($user->is_admin ? 'checked' : ''); ?>

                                       class="role-input">
                                <label for="role_admin" class="role-label">
                                    <div class="role-icon admin">
                                        <i class="fas fa-crown"></i>
                                    </div>
                                    <div class="role-info">
                                        <span class="role-name">Administrateur</span>
                                        <span class="role-description">Accès complet à toutes les fonctionnalités</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle me-2"></i>Informations du compte
                    </h4>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Date d'inscription</span>
                            <span class="info-value"><?php echo e($user->created_at->format('d/m/Y à H:i')); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Dernière connexion</span>
                            <span class="info-value"><?php echo e($user->updated_at->format('d/m/Y à H:i')); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email vérifié</span>
                            <span class="info-value <?php echo e($user->email_verified_at ? 'verified' : 'not-verified'); ?>">
                                <?php echo e($user->email_verified_at ? 'Oui' : 'Non'); ?>

                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Statut du compte</span>
                            <span class="info-value active">Actif</span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<style>
/* Header de la page */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.back-btn {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
}

/* Alertes modernes */
.alert-modern {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

/* Container d'édition */
.edit-container {
    max-width: 800px;
    margin: 0 auto;
}

.edit-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

/* Aperçu de l'utilisateur */
.user-preview {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 16px;
    margin-bottom: 2rem;
}

.user-avatar-large {
    position: relative;
}

.avatar-img-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.admin-badge-large {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #ffc107, #ff8c00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.admin-badge-large i {
    font-size: 1rem;
    color: white;
}

.user-info-preview {
    flex: 1;
}

.user-name-large {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.user-email-large {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.user-status-large {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-dot-large {
    width: 16px;
    height: 16px;
    border-radius: 50%;
}

.status-dot-large.admin {
    background: #ffc107;
}

.status-dot-large.user {
    background: #28a745;
}

.status-text-large {
    font-size: 1rem;
    color: #6c757d;
    font-weight: 500;
}

/* Sections du formulaire */
.form-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 16px;
    border: 1px solid #e9ecef;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

/* Groupes de formulaire */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.9rem;
    margin-top: 0.25rem;
}

/* Options de rôle */
.role-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.role-option {
    position: relative;
}

.role-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.role-label {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.role-input:checked + .role-label {
    border-color: #667eea;
    background: linear-gradient(135deg, #f3f0fa 0%, #e8f2ff 100%);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
}

.role-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #28a745, #20c997);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.role-icon.admin {
    background: linear-gradient(135deg, #ffc107, #ff8c00);
}

.role-info {
    flex: 1;
}

.role-name {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.role-description {
    font-size: 0.9rem;
    color: #6c757d;
}

/* Grille d'informations */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.info-item {
    padding: 1rem;
    background: white;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.info-label {
    display: block;
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.info-value {
    display: block;
    font-weight: 600;
    color: #2c3e50;
}

.info-value.verified {
    color: #28a745;
}

.info-value.not-verified {
    color: #dc3545;
}

.info-value.active {
    color: #28a745;
}

/* Actions du formulaire */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .user-preview {
        flex-direction: column;
        text-align: center;
    }
    
    .role-options {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>