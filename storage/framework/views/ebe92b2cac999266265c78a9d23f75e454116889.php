<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation de commande - EazyStore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f3f4f6;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .logo {
            margin-bottom: 10px;
        }
        .content {
            background-color: #fff;
            padding: 24px;
            border-radius: 0 0 8px 8px;
        }
        .order-details {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border-left: 4px solid #4F46E5;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .products-table th, .products-table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        .products-table th {
            background: #f3f4f6;
        }
        .button {
            display: inline-block;
            background-color: #4F46E5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
        .service-client {
            background: #f3f4f6;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0 0 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <!-- Logo SVG directement intégré -->
            <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg" width="48" height="48">
                <path d="M305.8 81.125C305.77 80.995 305.69 80.885 305.65 80.755C305.56 80.525 305.49 80.285 305.37 80.075C305.29 79.935 305.17 79.815 305.07 79.685C304.94 79.515 304.83 79.325 304.68 79.175C304.55 79.045 304.39 78.955 304.25 78.845C304.09 78.715 303.95 78.575 303.77 78.475L251.32 48.275C249.97 47.495 248.31 47.495 246.96 48.275L194.51 78.475C194.33 78.575 194.19 78.725 194.03 78.845C193.89 78.955 193.73 79.045 193.6 79.175C193.45 79.325 193.34 79.515 193.21 79.685C193.11 79.815 192.99 79.935 192.91 80.075C192.79 80.285 192.71 80.525 192.63 80.755C192.58 80.875 192.51 80.995 192.48 81.125C192.38 81.495 192.33 81.875 192.33 82.265V139.625L148.62 164.795V52.575C148.62 52.185 148.57 51.805 148.47 51.435C148.44 51.305 148.36 51.195 148.32 51.065C148.23 50.835 148.16 50.595 148.04 50.385C147.96 50.245 147.84 50.125 147.74 49.995C147.61 49.825 147.5 49.635 147.35 49.485C147.22 49.355 147.06 49.265 146.92 49.155C146.76 49.025 146.62 48.885 146.44 48.785L93.99 18.585C92.64 17.805 90.98 17.805 89.63 18.585L37.18 48.785C37 48.885 36.86 49.035 36.7 49.155C36.56 49.265 36.4 49.355 36.27 49.485C36.12 49.635 36.01 49.825 35.88 49.995C35.78 50.125 35.66 50.245 35.58 50.385C35.46 50.595 35.38 50.835 35.3 51.065C35.25 51.185 35.18 51.305 35.15 51.435C35.05 51.805 35 52.185 35 52.575V232.235C35 233.795 35.84 235.245 37.19 236.025L142.1 296.425C142.33 296.555 142.58 296.635 142.82 296.725C142.93 296.765 143.04 296.835 143.16 296.865C143.53 296.965 143.9 297.015 144.28 297.015C144.66 297.015 145.03 296.965 145.4 296.865C145.5 296.835 145.59 296.775 145.69 296.745C145.95 296.655 146.21 296.565 146.45 296.435L251.36 236.035C252.72 235.255 253.55 233.815 253.55 232.245V174.885L303.81 145.945C305.17 145.165 306 143.725 306 142.155V82.265C305.95 81.875 305.89 81.495 305.8 81.125ZM144.2 227.205L100.57 202.515L146.39 176.135L196.66 147.195L240.33 172.335L208.29 190.625L144.2 227.205ZM244.75 114.995V164.795L226.39 154.225L201.03 139.625V89.825L219.39 100.395L244.75 114.995ZM249.12 57.105L292.81 82.265L249.12 107.425L205.43 82.265L249.12 57.105ZM114.49 184.425L96.13 194.995V85.305L121.49 70.705L139.85 60.135V169.815L114.49 184.425ZM91.76 27.425L135.45 52.585L91.76 77.745L48.07 52.585L91.76 27.425ZM43.67 60.135L62.03 70.705L87.39 85.305V202.545V202.555V202.565C87.39 202.735 87.44 202.895 87.46 203.055C87.49 203.265 87.49 203.485 87.55 203.695V203.705C87.6 203.875 87.69 204.035 87.76 204.195C87.84 204.375 87.89 204.575 87.99 204.745C87.99 204.745 87.99 204.755 88 204.755C88.09 204.905 88.22 205.035 88.33 205.175C88.45 205.335 88.55 205.495 88.69 205.635L88.7 205.645C88.82 205.765 88.98 205.855 89.12 205.965C89.28 206.085 89.42 206.225 89.59 206.325C89.6 206.325 89.6 206.325 89.61 206.335C89.62 206.335 89.62 206.345 89.63 206.345L139.87 234.775V285.065L43.67 229.705V60.135ZM244.75 229.705L148.58 285.075V234.775L219.8 194.115L244.75 179.875V229.705ZM297.2 139.625L253.49 164.795V114.995L278.85 100.395L297.21 89.825V139.625H297.2Z"/>
            </svg>
        </div>
        <h1>EazyStore</h1>
        <p>Confirmation de votre commande</p>
    </div>

    <div class="content">
        <h2>
            Bonjour <?php echo e(explode(' ', $order->user->name)[0]); ?>,
        </h2>
        <p>
            Nous avons bien reçu votre commande et nous vous remercions pour votre confiance !
        </p>

        <div class="order-details">
            <h3>Détails de votre commande</h3>
            <p><strong>N° Commande :</strong> <?php echo e($order->order_number); ?></p>
            <p><strong>Date :</strong> <?php echo e($order->created_at->format('d/m/Y à H:i')); ?></p>
            <p><strong>Total :</strong> <?php echo e(number_format($order->total, 0, ',', ' ')); ?> FCFA</p>
            <p><strong>Statut :</strong> <?php echo e(ucfirst($order->status)); ?></p>
            <?php if($order->payment): ?>
                <p><strong>Mode de paiement :</strong> <?php echo e($order->payment->payment_method); ?></p>
                <p><strong>Statut du paiement :</strong> <?php echo e($order->payment->status ? 'Payé' : 'En attente'); ?></p>
            <?php endif; ?>
        </div>

        <h3>Produits commandés :</h3>
        <table class="products-table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->product->name); ?></td>
                    <td><?php echo e($item->quantity); ?></td>
                    <td><?php echo e(number_format($item->price, 0, ',', ' ')); ?> FCFA</td>
                    <td><?php echo e(number_format($item->price * $item->quantity, 0, ',', ' ')); ?> FCFA</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <a href="<?php echo e(route('orders.show', $order)); ?>" class="button">Voir ma commande</a>
        <a href="<?php echo e(route('paiement')); ?>">Moyens de paiement</a>

        <div class="service-client">
            <strong>Service client :</strong><br>
            Téléphone : +221 76 676 25 42<br>
            Email : <a href="mailto:gnaweparfait1@gmail.com">gnaweparfait1@gmail.com</a><br>
            Horaires : Lun-Sam 9h-18h
        </div>
    </div>

    <div class="footer">
        <p>EazyStore - Rue de Almadies, Dakar, Sénégal</p>
        <p>Merci pour votre confiance !</p>
    </div>
</body>
</html> <?php /**PATH C:\Users\User\Desktop\EazyStore\resources\views/emails/order-confirmation.blade.php ENDPATH**/ ?>