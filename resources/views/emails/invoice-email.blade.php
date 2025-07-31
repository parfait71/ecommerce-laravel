<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Votre facture - EazyStore</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 0 0 8px 8px;
        }
        .invoice-info {
            background-color: white;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border-left: 4px solid #4F46E5;
        }
        .button {
            display: inline-block;
            background-color: #4F46E5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
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
        <p>Votre facture est prête</p>
    </div>

    <div class="content">
        <h2>Bonjour {{ $order->user->name }},</h2>
        
        <p>Votre facture pour la commande n°{{ $order->order_number }} est maintenant disponible.</p>

        <div class="invoice-info">
            <h3>Détails de la facture</h3>
            <p><strong>N° Facture :</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>N° Commande :</strong> {{ $order->order_number }}</p>
            <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}</p>
            <p><strong>Total :</strong> {{ number_format($order->total, 0, ',', ' ') }} FCFA</p>
        </div>

        <p>Vous trouverez votre facture en pièce jointe de cet email.</p>

        <p>Si vous avez des questions concernant cette facture, n'hésitez pas à nous contacter :</p>
        <ul>
            <li>Téléphone : +221 76 676 25 42</li>
            <li>Email : gnaweparfait1@gmail.com</li>
        </ul>

        <a href="{{ route('orders.show', $order) }}" class="button">Voir ma commande</a>
    </div>

    <div class="footer">
        <p>EazyStore - Rue de Almadies, Dakar, Sénégal</p>
        <p>Merci pour votre confiance !</p>
    </div>
</body>
</html> 