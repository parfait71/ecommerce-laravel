<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Services\EmailService;

class InvoiceService
{
    public function generateInvoice(Order $order)
    {
        // Vérifier si une facture existe déjà
        $invoice = $order->invoice;
        
        if (!$invoice) {
            $invoice = Invoice::create([
                'order_id' => $order->id,
            ]);
        }

        // Générer le PDF
        $pdf = PDF::loadView('pdfs.invoice', [
            'order' => $order,
            'invoice' => $invoice,
        ]);

        // Sauvegarder le PDF
        $filename = 'invoice_' . $order->id . '_' . date('Y-m-d_H-i-s') . '.pdf';
        $path = 'invoices/' . $filename;
        
        Storage::put('public/' . $path, $pdf->output());

        // Mettre à jour le chemin du PDF
        $invoice->update(['pdf_path' => $path]);

        // Envoyer automatiquement l'email avec facture
        $emailService = new EmailService();
        $emailService->sendInvoiceEmail($order, $invoice);

        return $invoice;
    }

    public function downloadInvoice(Order $order)
    {
        $invoice = $order->invoice;
        
        if (!$invoice || !$invoice->pdf_path) {
            $invoice = $this->generateInvoice($order);
        }

        $path = storage_path('app/public/' . $invoice->pdf_path);
        
        if (!file_exists($path)) {
            $invoice = $this->generateInvoice($order);
            $path = storage_path('app/public/' . $invoice->pdf_path);
        }

        return $path;
    }
} 