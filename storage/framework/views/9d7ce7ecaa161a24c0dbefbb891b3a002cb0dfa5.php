<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Analytics - EazyStore</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 28px;
            margin: 0 0 10px 0;
            font-weight: 800;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
            font-size: 14px;
        }
        
        .stats-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .stat-item {
            text-align: center;
            flex: 1;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: 800;
            color: #667eea;
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
            font-weight: 600;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #667eea;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th {
            background: #667eea;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: 700;
            font-size: 11px;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .highlight {
            background: #e8f5e8;
            font-weight: 600;
        }
        
        .revenue {
            color: #28a745;
            font-weight: 700;
        }
        
        .warning {
            color: #ffc107;
            font-weight: 600;
        }
        
        .danger {
            color: #dc3545;
            font-weight: 600;
        }
        
        .chart-section {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .chart-title {
            font-size: 14px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .chart-data {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .chart-item {
            flex: 1;
            min-width: 120px;
            text-align: center;
            margin: 5px;
            padding: 10px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        
        .chart-value {
            font-size: 16px;
            font-weight: 700;
            color: #667eea;
        }
        
        .chart-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .summary-box {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .summary-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .summary-content {
            font-size: 12px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Rapport Analytics EazyStore</h1>
        <p><strong>Analyse complète des performances</strong></p>
        <p>Généré le <?php echo e(date('d/m/Y à H:i')); ?></p>
    </div>

    <div class="summary-box">
        <div class="summary-title">📈 Résumé Exécutif</div>
        <div class="summary-content">
            Ce rapport présente une analyse complète des performances de votre boutique en ligne EazyStore. 
            Il inclut les métriques clés, l'évolution des ventes, les produits les plus performants et les insights utilisateurs.
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-item">
            <span class="stat-number"><?php echo e($stats['total_products']); ?></span>
            <span class="stat-label">Produits</span>
        </div>
        <div class="stat-item">
            <span class="stat-number"><?php echo e($stats['total_categories']); ?></span>
            <span class="stat-label">Catégories</span>
        </div>
        <div class="stat-item">
            <span class="stat-number"><?php echo e($stats['total_orders']); ?></span>
            <span class="stat-label">Commandes</span>
        </div>
        <div class="stat-item">
            <span class="stat-number"><?php echo e($stats['total_users']); ?></span>
            <span class="stat-label">Utilisateurs</span>
        </div>
        <div class="stat-item">
            <span class="stat-number revenue"><?php echo e(number_format($stats['total_revenue'], 0, ',', ' ')); ?> FCFA</span>
            <span class="stat-label">Chiffre d'affaires</span>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">💰 Performance Financière</h2>
        
        <div class="chart-section">
            <div class="chart-title">📊 Métriques de Paiement</div>
            <div class="chart-data">
                <div class="chart-item">
                    <div class="chart-value"><?php echo e($stats['paid_orders']); ?></div>
                    <div class="chart-label">Commandes Payées</div>
                </div>
                <div class="chart-item">
                    <div class="chart-value"><?php echo e($stats['unpaid_orders']); ?></div>
                    <div class="chart-label">Commandes en Attente</div>
                </div>
                <div class="chart-item">
                    <div class="chart-value"><?php echo e($stats['total_orders'] > 0 ? round(($stats['paid_orders'] / $stats['total_orders']) * 100, 1) : 0); ?>%</div>
                    <div class="chart-label">Taux de Conversion</div>
                </div>
                <div class="chart-item">
                    <div class="chart-value"><?php echo e($stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / $stats['total_orders'], 0, ',', ' ') : 0); ?> FCFA</div>
                    <div class="chart-label">Panier Moyen</div>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($stats['monthly_sales']) && $stats['monthly_sales']->count() > 0): ?>
    <div class="section">
        <h2 class="section-title">📅 Évolution des Ventes par Mois</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Mois</th>
                    <th>Ventes (FCFA)</th>
                    <th>Nombre de Commandes</th>
                    <th>Panier Moyen</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $stats['monthly_sales']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $months = [
                            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                        ];
                        $avgCart = $sale->order_count > 0 ? $sale->total_sales / $sale->order_count : 0;
                    ?>
                    <tr>
                        <td><strong><?php echo e($months[$sale->month] ?? $sale->month); ?></strong></td>
                        <td class="revenue"><?php echo e(number_format($sale->total_sales, 0, ',', ' ')); ?> FCFA</td>
                        <td><?php echo e($sale->order_count); ?></td>
                        <td class="revenue"><?php echo e(number_format($avgCart, 0, ',', ' ')); ?> FCFA</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <?php if(isset($stats['top_products']) && $stats['top_products']->count() > 0): ?>
    <div class="section">
        <h2 class="section-title">🏆 Top Produits les Plus Vendus</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Rang</th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité Vendue</th>
                    <th>Revenus Générés</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $stats['top_products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="<?php echo e($index < 3 ? 'highlight' : ''); ?>">
                        <td><strong>#<?php echo e($index + 1); ?></strong></td>
                        <td><strong><?php echo e($product->name); ?></strong></td>
                        <td><?php echo e(number_format($product->price, 0, ',', ' ')); ?> FCFA</td>
                        <td><?php echo e($product->total_sold ?? 0); ?></td>
                        <td class="revenue"><?php echo e(number_format(($product->price * ($product->total_sold ?? 0)), 0, ',', ' ')); ?> FCFA</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="section">
        <h2 class="section-title">📋 Recommandations</h2>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #667eea;">
            <h3 style="margin: 0 0 10px 0; color: #2c3e50; font-size: 14px;">💡 Actions Recommandées</h3>
            <ul style="margin: 0; padding-left: 20px; font-size: 11px; line-height: 1.6;">
                <li><strong>Optimisation des produits :</strong> Mettez en avant les produits les plus vendus</li>
                <li><strong>Gestion des stocks :</strong> Surveillez les produits populaires pour éviter les ruptures</li>
                <li><strong>Marketing ciblé :</strong> Créez des campagnes basées sur les tendances de vente</li>
                <li><strong>Expérience utilisateur :</strong> Améliorez le processus de paiement pour augmenter le taux de conversion</li>
                <li><strong>Analyse continue :</strong> Surveillez régulièrement ces métriques pour ajuster votre stratégie</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p><strong>EazyStore Analytics</strong> - Rapport généré automatiquement</p>
        <p>Ce document contient des informations confidentielles et stratégiques</p>
        <p>Pour toute question, contactez l'équipe d'administration</p>
    </div>
</body>
</html> <?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/admin/analytics/pdf.blade.php ENDPATH**/ ?>