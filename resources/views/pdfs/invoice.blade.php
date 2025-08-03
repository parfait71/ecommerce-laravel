<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-info {
            float: left;
            width: 50%;
        }
        .invoice-info {
            float: right;
            width: 40%;
            text-align: right;
        }
        .clear {
            clear: both;
        }
        .customer-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-section {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        .total-row {
            padding: 5px 0;
        }
        .total-row.total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #333;
            padding-top: 10px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EazyStore</h1>
        <p>Votre boutique en ligne de confiance</p>
    </div>

    <div class="company-info">
        <h3>EazyStore</h3>
        <p>Rue de Almadies<br>
        Dakar, Sénégal<br>
        Tél: +221 76 676 25 42<br>
        Email: contact@eazystore.com</p>
    </div>

    <div class="invoice-info">
        <h2>FACTURE</h2>
        <p><strong>N° Facture:</strong> {{ $invoice->id }}</p>
        <p><strong>N° Commande:</strong> {{ $order->id }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
        <p><strong>Statut:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <div class="clear"></div>

    <div class="customer-info">
        <h3>Informations Client</h3>
        <p><strong>Nom:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        @if($order->payment)
            <p><strong>Mode de paiement:</strong> {{ $order->payment->payment_method }}</p>
            <p><strong>Statut du paiement:</strong> {{ $order->payment->status ? 'Payé' : 'En attente' }}</p>
        @endif
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Sous-total:</span>
            <span style="float: right;">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
        </div>
        <div class="total-row">
            <span>TVA (20%):</span>
            <span style="float: right;">{{ number_format($order->total * 0.2, 0, ',', ' ') }} FCFA</span>
        </div>
        <div class="total-row total">
            <span>Total TTC:</span>
            <span style="float: right;">{{ number_format($order->total * 1.2, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <div class="clear"></div>

    <div class="footer">
        <p>Merci pour votre confiance !</p>
        <p>EazyStore - Votre satisfaction est notre priorité</p>
    </div>
</body>
</html> 