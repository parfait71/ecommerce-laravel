<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function generate($orderId)
    {
        $order = Order::findOrFail($orderId);
        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->download('invoice.pdf');
    }
}

