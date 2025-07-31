<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body
    x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('dark', value => { localStorage.setItem('theme', value ? 'dark' : 'light') })"
    :class="{ 'dark': dark }"
    class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-gray-100 transition-colors duration-300 {{ auth()->check() ? 'user-logged-in' : '' }}">

    <div class="min-h-screen flex flex-col min-w-full">
        <!-- Toggle Dark Mode -->
        <div class="w-full flex justify-end pr-8 pt-4">
            <button @click="dark = !dark"
                    class="px-3 py-1 rounded bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm font-semibold shadow hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                <span x-text="dark ? '☀️ Mode clair' : '🌙 Mode sombre'"></span>
            </button>
        </div>

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white shadow-sm mb-4 dark:bg-gray-900 dark:shadow-md dark:border-b dark:border-gray-700 transition-colors duration-300">
                <div class="container py-4">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="container mb-5 p-4 bg-white dark:bg-gray-900 rounded shadow transition-colors duration-300">
            @yield('content')
        </main>
    </div>

    <!-- WhatsApp Shortcut -->
    <a href="https://wa.me/221766762542" target="_blank"
       style="position:fixed;bottom:24px;right:24px;z-index:9999;background:#25D366;color:white;border-radius:50%;width:56px;height:56px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px #0003;text-decoration:none;font-size:2rem;"
       title="Discuter sur WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="white">
            <path d="M16 3C9.373 3 4 8.373 4 15c0 2.385.832 4.584 2.236 6.393L4 29l7.824-2.05C13.41 27.633 14.686 28 16 28c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22c-1.13 0-2.24-.188-3.29-.558l-.235-.08-4.65 1.22 1.24-4.53-.153-.236C6.64 18.13 6 16.6 6 15c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10zm5.29-7.71c-.29-.145-1.71-.844-1.98-.94-.27-.1-.47-.145-.67.145-.2.29-.77.94-.95 1.13-.17.2-.35.22-.64.075-.29-.145-1.22-.45-2.33-1.43-.86-.77-1.44-1.72-1.61-2-.17-.29-.02-.44.13-.58.13-.13.29-.34.43-.51.14-.17.19-.29.29-.48.1-.2.05-.37-.025-.52-.075-.145-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51-.17-.01-.37-.01-.57-.01-.2 0-.52.075-.8.37-.27.29-1.05 1.02-1.05 2.48 0 1.45 1.07 2.85 1.22 3.05.15.2 2.1 3.2 5.08 4.36.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.09 1.71-.7 1.95-1.38.24-.68.24-1.26.17-1.38-.07-.12-.26-.19-.55-.33z"/>
        </svg>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('SW registered: ', registration);
                    })
                    .catch(registrationError => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }

        // PWA Install Prompt - Version robuste
        let deferredPrompt;
        let installButtonShown = false;
        
        // Fonction pour créer le bouton d'installation
        function createInstallButton() {
            if (installButtonShown) return;
            
            // Supprimer l'ancien bouton s'il existe
            const existingButton = document.getElementById('pwa-install-banner');
            if (existingButton) {
                existingButton.remove();
            }
            
            // Créer le nouveau bouton
            const installDiv = document.createElement('div');
            installDiv.id = 'pwa-install-banner';
            installDiv.className = 'fixed-bottom p-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center shadow-lg';
            installDiv.style.zIndex = '10000';
            installDiv.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="me-2">📱</span>
                        <span class="fw-bold">Installer EazyStore</span>
                    </div>
                    <button id="install-pwa-btn" class="btn btn-light btn-sm fw-bold">
                        Installer
                    </button>
                </div>
            `;
            document.body.appendChild(installDiv);
            installButtonShown = true;
        }
        
        // Écouter l'événement beforeinstallprompt
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('beforeinstallprompt event triggered');
            e.preventDefault();
            deferredPrompt = e;
            
            // Afficher le bouton pour les utilisateurs non connectés
            if (!document.body.classList.contains('user-logged-in')) {
                setTimeout(createInstallButton, 1000);
            }
        });
        
        // Gestionnaire pour le bouton d'installation
        document.addEventListener('click', (e) => {
            if (e.target.id === 'install-pwa-btn') {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('PWA installée avec succès !');
                            document.getElementById('pwa-install-banner').remove();
                        }
                        deferredPrompt = null;
                    });
                }
            }
        });
        
        // Gestionnaire pour le bouton de test d'installation
        document.addEventListener('click', (e) => {
            if (e.target.id === 'test-install-btn') {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('PWA installée avec succès via le bouton de test !');
                            alert('🎉 EazyStore a été installé avec succès !');
                        }
                        deferredPrompt = null;
                    });
                } else {
                    // Instructions détaillées selon le navigateur
                    const userAgent = navigator.userAgent;
                    let instructions = '';
                    
                    if (userAgent.includes('Chrome')) {
                        instructions = '📱 Pour installer EazyStore sur Chrome :\n\n1. Cliquez sur l\'icône 📌 dans la barre d\'adresse\n2. Ou cliquez sur "Installer" dans le menu\n3. Ou utilisez Ctrl+Shift+I → Application → Manifest → Install';
                    } else if (userAgent.includes('Safari')) {
                        instructions = '📱 Pour installer EazyStore sur Safari :\n\n1. Cliquez sur "Partager" (icône carrée)\n2. Sélectionnez "Sur l\'écran d\'accueil"\n3. Cliquez sur "Ajouter"';
                    } else if (userAgent.includes('Firefox')) {
                        instructions = '📱 Pour installer EazyStore sur Firefox :\n\n1. Cliquez sur l\'icône 📌 dans la barre d\'adresse\n2. Ou utilisez le menu → "Installer l\'application"';
                    } else {
                        instructions = '📱 Pour installer EazyStore :\n\n1. Chrome : Icône 📌 dans la barre d\'adresse\n2. Safari : Partager → Sur l\'écran d\'accueil\n3. Firefox : Icône 📌 dans la barre d\'adresse\n4. Edge : Icône 📌 dans la barre d\'adresse';
                    }
                    
                    alert(instructions);
                }
            }
            
            // Gestionnaire pour le bouton de debug PWA
            if (e.target.id === 'debug-pwa-btn') {
                const debugInfo = {
                    'Service Worker Support': 'serviceWorker' in navigator,
                    'HTTPS/SSL': window.location.protocol === 'https:',
                    'Localhost': window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1',
                    'Manifest Loaded': !!document.querySelector('link[rel="manifest"]'),
                    'Deferred Prompt': !!deferredPrompt,
                    'Standalone Mode': window.matchMedia('(display-mode: standalone)').matches,
                    'User Agent': navigator.userAgent,
                    'Current URL': window.location.href,
                    'Manifest URL': '/manifest.json'
                };
                
                let debugMessage = '🔍 Debug PWA - Informations techniques :\n\n';
                for (const [key, value] of Object.entries(debugInfo)) {
                    debugMessage += `${key}: ${value}\n`;
                }
                
                debugMessage += '\n📋 Conditions pour l\'installation PWA :\n';
                debugMessage += '✅ HTTPS ou localhost\n';
                debugMessage += '✅ Manifest.json valide\n';
                debugMessage += '✅ Service Worker enregistré\n';
                debugMessage += '✅ Navigateur compatible (Chrome/Edge/Firefox)\n';
                debugMessage += '❌ Pas déjà installé\n';
                debugMessage += '❌ Pas en mode incognito\n';
                
                alert(debugMessage);
            }
        });
        
        // Vérifier si l'app est déjà installée
        window.addEventListener('load', () => {
            if (window.matchMedia('(display-mode: standalone)').matches) {
                console.log('App déjà installée et en mode standalone');
            }
        });
    </script>
</body>
</html>
