<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #<?php echo e($invoice->invoice_number); ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            color: #333; 
            line-height: 1.4;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            margin: 0 0 8px 0;
            color: #2c3e50;
        }
        .header p {
            font-size: 14px;
            margin: 0;
            color: #7f8c8d;
        }
        .company-info {
            float: left;
            width: 50%;
            font-size: 12px;
        }
        .invoice-info {
            float: right;
            width: 40%;
            text-align: right;
            font-size: 12px;
        }
        .invoice-info h2 {
            font-size: 20px;
            margin: 0 0 15px 0;
            color: #2c3e50;
        }
        .invoice-info p {
            margin: 5px 0;
        }
        .clear {
            clear: both;
        }
        .client-section {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            border-radius: 5px;
        }
        .client-section h3 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 16px;
        }
        .client-section p {
            margin: 8px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 12px;
        }
        th, td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #ecf0f1;
            font-weight: bold;
            font-size: 13px;
            color: #2c3e50;
        }
        .totals {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 12px;
        }
        .total-final {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #2c3e50;
            margin-top: 12px;
            padding-top: 12px;
            color: #2c3e50;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #7f8c8d;
            font-size: 11px;
            border-top: 1px solid #ecf0f1;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EazyStore</h1>
        <p>Votre boutique en ligne de confiance</p>
    </div>
    
    <div class="company-info">
        <strong>EazyStore</strong><br>
        Rue de Almadies<br>
        Dakar, Sénégal<br>
        Tél: +221 76 676 25 42<br>
        Email: gnaweparfait1@gmail.com
    </div>
    
    <div class="invoice-info">
        <h2>FACTURE</h2>
        <p><strong>N° Facture:</strong> <?php echo e($invoice->invoice_number); ?></p>
        <p><strong>N° Commande:</strong> <?php echo e($order->order_number); ?></p>
        <p><strong>Date:</strong> <?php echo e($order->created_at->format('d/m/Y à H:i')); ?></p>
    </div>
    
    <div class="clear"></div>
    
    <div class="client-section">
        <h3>Informations Client</h3>
        <p><strong>Nom:</strong> <?php echo e($order->user->name); ?></p>
        <p><strong>Email:</strong> <?php echo e($order->user->email); ?></p>
        <?php if($order->payment): ?>
            <p><strong>Mode de paiement:</strong> <?php echo e($order->payment->payment_method ?: 'Non renseigné'); ?></p>
            <p><strong>Statut du paiement:</strong> <?php echo e(strtolower($order->payment->status) === 'payé' ? 'Payé' : 'Non payé'); ?></p>
        <?php else: ?>
            <p><strong>Mode de paiement:</strong> Non renseigné</p>
            <p><strong>Statut du paiement:</strong> Non payé</p>
        <?php endif; ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->product->name); ?></td>
                <td><?php echo e(number_format($item->price, 0, ',', ' ')); ?> FCFA</td>
                <td><?php echo e($item->quantity); ?></td>
                <td><?php echo e(number_format($item->price * $item->quantity, 0, ',', ' ')); ?> FCFA</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div class="totals">
        <div class="total-row">
            <span>Total:</span>
            <span><?php echo e(number_format($order->total, 0, ',', ' ')); ?> FCFA</span>
        </div>
    </div>
    
    <div class="clear"></div>
    
    <div class="footer">
        <p>Merci pour votre confiance !</p>
        <p>EazyStore - Votre satisfaction est notre priorité</p>
    </div>
</body>
</html> <?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/pdfs/invoice.blade.php ENDPATH**/ ?>