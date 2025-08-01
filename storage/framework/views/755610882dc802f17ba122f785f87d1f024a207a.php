<nav class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="w-full flex flex-col items-center py-2 animate-fade-in-up">
            <!-- Logo centré -->
            <div class="mb-2 animate-slide-in-left w-full flex justify-center">
                <a href="<?php echo e(Auth::check() && Auth::user()->is_admin ? route('admin.dashboard') : route('home')); ?>">
                    <img src="<?php echo e(asset('images/logo.svg')); ?>"
                         alt="EazyStore"
                         class="mb-2 animate-slide-in-left mx-auto logo-responsive"
                         style="max-width: 120px; width: 100%; height: auto;"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                    <span style="display:none; font-size: 1.5rem; font-weight: bold; color: #667eea;">EazyStore</span>
                </a>
            </div>
            <!-- Menu horizontal centré et responsive -->
            <div class="flex flex-wrap justify-center space-x-4 sm:space-x-8 mt-2 animate-fade-in-up" style="animation-delay: 0.2s;">
                <a href="<?php echo e(url('/')); ?>" class="btn btn-primary px-4 py-2 fw-bold mx-1">Accueil</a>
                <a href="<?php echo e(url('/catalogue')); ?>" class="btn btn-primary px-4 py-2 fw-bold mx-1">Catalogue</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->is_admin): ?>
                        <a href="<?php echo e(url('/admin/dashboard')); ?>" class="btn btn-primary px-4 py-2 fw-bold mx-1">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-primary px-4 py-2 fw-bold mx-1">Dashboard</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>