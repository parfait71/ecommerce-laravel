<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel')); ?></title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#4f46e5">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="EazyStore">
    <link rel="apple-touch-icon" href="/images/mon_logo.png">
    <link rel="manifest" href="/manifest.json">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        html {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 transition-colors duration-300 <?php echo e(auth()->check() ? 'user-logged-in' : ''); ?>">

    <div class="min-h-screen flex flex-col min-w-full">
        <!-- Navigation -->
        <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Page Heading -->
        <?php if (! empty(trim($__env->yieldContent('header')))): ?>
            <header class="bg-white shadow-sm mb-4 dark:bg-gray-900 dark:shadow-md dark:border-b dark:border-gray-700 transition-colors duration-300">
                <div class="container py-4">
                    <?php echo $__env->yieldContent('header'); ?>
                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="container mb-5 p-4 bg-white dark:bg-gray-900 rounded shadow transition-colors duration-300">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Script simple sans PWA pour éviter les boucles -->
    <script>
        // Script minimal pour éviter les problèmes de boucle
        console.log('EazyStore loaded successfully');
        
        // Debug des liens
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            
            // Vérifier les liens
            const catalogueLink = document.querySelector('a[href*="catalogue"]');
            const loginLink = document.querySelector('a[href*="login"]');
            
            console.log('Catalogue link:', catalogueLink);
            console.log('Login link:', loginLink);
            
            if (catalogueLink) {
                catalogueLink.addEventListener('click', function(e) {
                    console.log('Catalogue link clicked');
                });
            }
            
            if (loginLink) {
                loginLink.addEventListener('click', function(e) {
                    console.log('Login link clicked');
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/layouts/app.blade.php ENDPATH**/ ?>