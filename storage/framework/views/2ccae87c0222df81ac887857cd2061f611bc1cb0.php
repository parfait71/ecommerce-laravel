<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'EazyStore - Votre boutique en ligne'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts (Vite) -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --gray-color: #64748b;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .main-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin: 20px;
            overflow: hidden;
        }
        
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.2);
            border-radius: 0 0 20px 20px;
            padding: 15px 0;
        }
        
        .navbar-custom .navbar-nav .nav-link {
            margin: 0 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .navbar-custom .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .navbar-custom .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .navbar-custom .navbar-brand i {
            font-size: 1.8rem;
        }
        
        .card-modern {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        }
        
        /* Styles pour les cartes de produits similaires */
        .similar-products .card-modern {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .similar-products .card-modern:hover {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border-color: rgba(102, 126, 234, 0.3);
        }
        
        /* Styles pour les sections de détail produit */
        .product-detail-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .product-detail-section:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .newsletter-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: none;
            transition: all 0.3s ease;
            color: white;
        }
        
        .newsletter-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .newsletter-section .form-control {
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }
        
        .newsletter-section .form-control:focus {
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        }
        
        .newsletter-section .btn {
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
        }
        
        .newsletter-section .btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }
        
        /* Empty State Styles */
        .empty-state-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 2px dashed #dee2e6;
            transition: all 0.3s ease;
        }
        
        .empty-state-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: #adb5bd;
        }
        
        .empty-state-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        }
        
        .empty-state-icon i {
            font-size: 3rem;
            color: white;
        }
        
        .empty-state-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1rem;
        }
        
        .empty-state-description {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        .empty-state-button {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
            transition: all 0.3s ease;
        }
        
        .empty-state-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(13, 110, 253, 0.4);
        }
        
        /* Responsive Empty State */
        @media (max-width: 768px) {
            .empty-state-container {
                padding: 3rem 1.5rem;
            }
            
            .empty-state-icon {
                width: 100px;
                height: 100px;
            }
            
            .empty-state-icon i {
                font-size: 2.5rem;
            }
            
            .empty-state-title {
                font-size: 1.5rem;
            }
            
            .empty-state-description {
                font-size: 1rem;
            }
            
            .empty-state-button {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }
        
        /* Empty Cart Styles */
        .empty-cart-container {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            border-radius: 20px;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border: none;
            transition: all 0.3s ease;
            color: white;
        }
        
        .empty-cart-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }
        
        .empty-cart-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
        }
        
        .empty-cart-icon i {
            font-size: 3rem;
            color: white;
        }
        
        .empty-cart-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }
        
        .empty-cart-description {
            font-size: 1.1rem;
            color: #adb5bd;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        .empty-cart-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .empty-cart-button {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
            transition: all 0.3s ease;
            background: #007bff;
            border: none;
            color: white;
        }
        
        .empty-cart-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(13, 110, 253, 0.4);
            background: #0056b3;
            color: white;
        }
        
        .empty-cart-button-outline {
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 15px;
            border: 2px solid #007bff;
            background: transparent;
            color: #007bff;
            transition: all 0.3s ease;
        }
        
        .empty-cart-button-outline:hover {
            transform: translateY(-3px);
            background: rgba(0, 123, 255, 0.1);
            border-color: #0056b3;
            color: #0056b3;
        }
        
        /* Responsive Empty Cart */
        @media (max-width: 768px) {
            .empty-cart-container {
                padding: 3rem 1.5rem;
            }
            
            .empty-cart-icon {
                width: 100px;
                height: 100px;
            }
            
            .empty-cart-icon i {
                font-size: 2.5rem;
            }
            
            .empty-cart-title {
                font-size: 1.5rem;
            }
            
            .empty-cart-description {
                font-size: 1rem;
            }
            
            .empty-cart-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .empty-cart-button,
            .empty-cart-button-outline {
                padding: 12px 25px;
                font-size: 1rem;
                width: 100%;
                max-width: 300px;
            }
        }
        
        /* Amélioration de la lisibilité - Fonds professionnels */
        .contact-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #dee2e6;
        }
        
        .contact-section h4,
        .contact-section h5,
        .contact-section h6 {
            color: #2c3e50;
            font-weight: 700;
        }
        
        .contact-section p,
        .contact-section li,
        .contact-section small {
            color: #495057;
            line-height: 1.6;
        }
        
        .contact-section .text-muted {
            color: #6c757d !important;
        }
        
        .faq-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            margin-bottom: 2rem;
        }
        
        .faq-section h4 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .accordion-item {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        
        .accordion-button {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            color: #2c3e50;
            font-weight: 600;
            border: none;
            padding: 1rem 1.5rem;
        }
        
        .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        
        .accordion-button:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .accordion-body {
            background: #ffffff;
            color: #495057;
            padding: 1.5rem;
            line-height: 1.6;
        }
        
        .info-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }
        
        .info-card h5,
        .info-card h6 {
            color: #2c3e50;
            font-weight: 700;
        }
        
        .info-card p,
        .info-card li {
            color: #495057;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: 1px solid #b6d4da;
            color: #0c5460;
        }
        
        .category-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 2px solid #e9ecef;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 1.5rem;
        }
        
        .category-card:hover,
        .category-card.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-color: #007bff;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
        }
        
        .category-card:hover h6,
        .category-card.active h6,
        .category-card:hover i,
        .category-card.active i {
            color: white;
        }
        
        .category-card h6 {
            color: #2c3e50;
            font-weight: 600;
        }
        
        .category-card i {
            color: #6c757d;
        }
        
        .btn-modern {
            border-radius: 12px;
            font-weight: 600;
            padding: 12px 24px;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-custom .navbar-brand span {
                font-size: 1.2rem !important;
            }
            
            .navbar-custom .navbar-brand i {
                font-size: 1.4rem !important;
            }
            
            .display-5 {
                font-size: 2rem;
            }
            
            .lead {
                font-size: 1rem;
            }
            
            .card-modern {
                padding: 1.5rem !important;
            }
            
            .btn-modern {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
            
            .feature-card {
                margin-bottom: 1rem;
            }
            
            .stats-card {
                margin-bottom: 1rem;
            }
            
            .product-card {
                margin-bottom: 1.5rem;
            }
            
            .navbar-custom .navbar-nav .nav-link {
                margin: 0 4px;
                padding: 8px 12px !important;
                font-size: 0.9rem;
            }
            
            .navbar-custom .navbar-nav .nav-link i {
                margin-right: 0.5rem !important;
            }
        }
        
        @media (max-width: 576px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .display-5 {
                font-size: 1.8rem;
            }
            
            .card-modern {
                padding: 1rem !important;
            }
            
            .btn-modern {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
            
            .navbar-custom {
                padding: 10px 0;
            }
            
            .navbar-custom .navbar-brand span {
                font-size: 1rem !important;
            }
            
            .navbar-custom .navbar-brand i {
                font-size: 1.2rem !important;
            }
            
            .navbar-custom .navbar-nav .nav-link {
                margin: 0 2px;
                padding: 6px 8px !important;
                font-size: 0.8rem;
            }
            
            .navbar-custom .navbar-nav .nav-link i {
                margin-right: 0.3rem !important;
            }
            
            .navbar-custom .navbar-nav .nav-link span {
                display: none;
            }
            
            .navbar-custom .navbar-nav .nav-link i {
                font-size: 1.1rem;
            }
        }
        
        /* Amélioration de l'accessibilité */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Mode sombre automatique */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-color: #1a1a1a;
                --text-color: #ffffff;
                --card-bg: #2d2d2d;
                --border-color: #404040;
            }
            
            body {
                background-color: var(--bg-color);
                color: var(--text-color);
            }
            
            .card-modern {
                background: var(--card-bg);
                border-color: var(--border-color);
            }
            
            .navbar-custom {
                background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            }
        }
        
        /* Amélioration de la lisibilité */
        @media (max-width: 768px) {
            .text-center {
                text-align: center !important;
            }
            
            .text-start {
                text-align: left !important;
            }
            
            .text-end {
                text-align: right !important;
            }
            
            .d-flex {
                flex-direction: column;
            }
            
            .d-flex.align-items-center {
                align-items: flex-start !important;
            }
            
            .justify-content-between {
                justify-content: flex-start !important;
            }
            
            .justify-content-between > * {
                margin-bottom: 0.5rem;
            }
        }
        
        /* Optimisation pour les écrans tactiles */
        @media (hover: none) and (pointer: coarse) {
            .btn-modern:hover {
                transform: none;
            }
            
            .card-modern:hover {
                transform: none;
            }
            
            .product-card:hover {
                transform: none;
            }
            
            .navbar-custom .navbar-nav .nav-link:hover {
                transform: none;
            }
        }
        
        /* Pagination moderne et professionnelle */
        .modern-pagination-wrapper {
            margin: 2rem 0;
            padding: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 16px;
            border: 1px solid #e9ecef;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }
        
        .pagination-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        /* Informations de pagination */
        .pagination-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .pagination-stats {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #495057;
        }
        
        .current-range {
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .separator {
            color: #6c757d;
        }
        
        .total-items {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .items-label {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        .pagination-progress {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            max-width: 300px;
        }
        
        .progress-bar {
            flex: 1;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color) 0%, #0056b3 100%);
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        
        .progress-text {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
            white-space: nowrap;
        }
        
        /* Navigation de pagination */
        .pagination-navigation {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .pagination-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            background: white;
            color: #495057;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .pagination-btn:hover {
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }
        
        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f8f9fa;
            color: #adb5bd;
        }
        
        .pagination-btn.disabled:hover {
            transform: none;
            box-shadow: none;
            border-color: #e9ecef;
            background: #f8f9fa;
            color: #adb5bd;
        }
        
        .pagination-pages {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .page-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            background: white;
            color: #495057;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .page-number:hover {
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.25);
        }
        
        .page-number.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .page-ellipsis {
            color: #6c757d;
            font-weight: 600;
            padding: 0 0.5rem;
        }
        
        /* Actions rapides */
        .pagination-actions {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .page-jump {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .page-jump label {
            font-size: 0.9rem;
            color: #495057;
            font-weight: 600;
        }
        
        .jump-input-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .jump-input {
            width: 60px;
            padding: 0.5rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .jump-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .jump-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            background: var(--primary-color);
            color: white;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .jump-btn:hover {
            background: #0056b3;
            border-color: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .modern-pagination-wrapper {
                padding: 1rem;
            }
            
            .pagination-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .pagination-progress {
                max-width: 100%;
            }
            
            .pagination-navigation {
                flex-direction: column;
                gap: 1rem;
            }
            
            .pagination-btn {
                width: 100%;
                justify-content: center;
            }
            
            .pagination-pages {
                order: 2;
            }
            
            .pagination-btn-prev {
                order: 1;
            }
            
            .pagination-btn-next {
                order: 3;
            }
            
            .page-jump {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .jump-input-group {
                justify-content: center;
            }
        }
        
        @media (max-width: 576px) {
            .pagination-stats {
                font-size: 0.8rem;
            }
            
            .progress-text {
                font-size: 0.75rem;
            }
            
            .page-number {
                width: 36px;
                height: 36px;
                font-size: 0.8rem;
            }
            
            .pagination-btn {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
        }
        

        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 60px 0;
            border-radius: 20px;
            margin-bottom: 30px;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stats-card {
            background: linear-gradient(135deg, var(--success-color), var(--info-color));
            color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
        }
        
        .footer-custom {
            background: var(--dark-color);
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }

        /* Styles pour les textes sur fond coloré - forcer le blanc */
        .display-5,
        .display-5 i,
        .display-5 span,
        .lead,
        .navbar-brand,
        .navbar-brand *,
        .navbar-custom .navbar-nav .nav-link,
        .navbar-custom .navbar-nav .nav-link i,
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-brand * {
            color: white !important;
        }

        .lead {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        /* Styles pour les éléments sur fond coloré */
        [class*="bg-"] .text-dark,
        [class*="bg-"] .text-secondary,
        [class*="bg-"] .text-muted {
            color: white !important;
        }

        /* Styles pour les headers sur fond coloré */
        .bg-primary h1,
        .bg-primary h2,
        .bg-primary h3,
        .bg-primary h4,
        .bg-primary h5,
        .bg-primary h6,
        .bg-primary p,
        .bg-primary span,
        .bg-primary i {
            color: white !important;
        }

        /* Styles pour les gradients avec texte */
        [style*="gradient"] .text-dark,
        [style*="gradient"] .text-secondary,
        [style*="gradient"] .text-muted {
            color: white !important;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Page Heading -->
        <?php if (! empty(trim($__env->yieldContent('header')))): ?>
            <header class="hero-section">
                <div class="container">
                    <?php echo $__env->yieldContent('header'); ?>
                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="container py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        
        <!-- Footer -->
        <footer class="footer-custom">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5><i class="fas fa-store me-2"></i>EazyStore</h5>
                        <p>Votre boutique en ligne de confiance pour tous vos besoins.</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Liens rapides</h6>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo e(route('products.index')); ?>" class="text-white-50">Catalogue</a></li>
                            <li><a href="<?php echo e(route('contact')); ?>" class="text-white-50">Contact</a></li>
                            <li><a href="<?php echo e(route('faq')); ?>" class="text-white-50">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6>Suivez-nous</h6>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center">
                    <p>&copy; <?php echo e(date('Y')); ?> EazyStore. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/layouts/app.blade.php ENDPATH**/ ?>