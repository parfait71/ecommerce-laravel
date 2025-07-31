<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mise à jour de commande - EazyStore</title>
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
        .content {
            background-color: #fff;
            padding: 24px;
            border-radius: 0 0 8px 8px;
        }
        .status-update {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border-left: 4px solid #4F46E5;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            color: white;
            background-color: #10B981;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>EazyStore</h1>
        <p>Mise à jour de votre commande</p>
    </div>

    <div class="content">
        <h2>Bonjour {{ explode(' ', $order->user->name)[0] }},</h2>
        
        <p>Le statut de votre commande a été mis à jour.</p>

        <div class="status-update">
            <h3>Détails de la commande</h3>
            <p><strong>N° Commande :</strong> {{ $order->order_number }}</p>
            <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            <p><strong>Total :</strong> {{ number_format($order->total, 0, ',', ' ') }} FCFA</p>
            
            @if($oldStatus)
                <p><strong>Ancien statut :</strong> {{ ucfirst($oldStatus) }}</p>
            @endif
            
            <p><strong>Nouveau statut :</strong> 
                <span class="status-badge">{{ ucfirst($order->status) }}</span>
            </p>
        </div>

        @if($order->status === 'expédiée')
            <p>Votre commande a été expédiée et devrait arriver sous peu. Vous recevrez un email de confirmation de livraison.</p>
        @elseif($order->status === 'livrée')
            <p>Votre commande a été livrée avec succès ! Nous espérons que vous êtes satisfait de votre achat.</p>
        @elseif($order->status === 'annulée')
            <p>Votre commande a été annulée. Si vous avez des questions, n'hésitez pas à nous contacter.</p>
        @else
            <p>Nous traitons votre commande et vous tiendrons informé de son avancement.</p>
        @endif

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