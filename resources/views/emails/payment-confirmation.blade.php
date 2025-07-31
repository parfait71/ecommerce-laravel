<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation de paiement - EazyStore</title>
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
            background-color: #10B981;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #fff;
            padding: 24px;
            border-radius: 0 0 8px 8px;
        }
        .payment-details {
            background-color: #f0fdf4;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border-left: 4px solid #10B981;
        }
        .success-icon {
            font-size: 48px;
            color: #10B981;
            text-align: center;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #10B981;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>EazyStore</h1>
        <p>Confirmation de paiement</p>
    </div>

    <div class="content">
        <div class="success-icon">✅</div>
        
        <h2>Bonjour {{ explode(' ', $order->user->name)[0] }},</h2>
        
        <p>Nous avons bien reçu votre paiement ! Votre commande est maintenant confirmée et sera traitée dans les plus brefs délais.</p>

        <div class="payment-details">
            <h3>Détails du paiement</h3>
            <p><strong>N° Commande :</strong> {{ $order->order_number }}</p>
            <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            <p><strong>Montant payé :</strong> {{ number_format($order->total, 0, ',', ' ') }} FCFA</p>
            <p><strong>Mode de paiement :</strong> {{ $order->payment->payment_method ?? 'Non spécifié' }}</p>
            <p><strong>Statut :</strong> <span style="color: #10B981; font-weight: bold;">Payé</span></p>
        </div>

        <p>Votre commande va maintenant être préparée et expédiée. Vous recevrez un email dès que votre commande sera expédiée.</p>

        <a href="{{ route('orders.show', $order) }}" class="button">Voir ma commande</a>

        <div style="margin-top: 30px; padding: 15px; background: #f3f4f6; border-radius: 5px;">
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
</html> 