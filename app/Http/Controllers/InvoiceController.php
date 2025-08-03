<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function generate(Order $order)
    {
        try {
            $invoice = $this->invoiceService->generateInvoice($order);
            
            return response()->json([
                'success' => true,
                'message' => 'Facture générée avec succès',
                'invoice_id' => $invoice->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération de la facture: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download(Order $order)
    {
        try {
            $path = $this->invoiceService->downloadInvoice($order);
            
            return response()->download($path, 'facture_' . $order->id . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du téléchargement de la facture: ' . $e->getMessage());
        }
    }

    public function view(Order $order)
    {
        try {
            $invoice = $order->invoice;
            
            if (!$invoice) {
                $invoice = $this->invoiceService->generateInvoice($order);
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdfs.invoice', [
                'order' => $order,
                'invoice' => $invoice,
            ]);

            return $pdf->stream('facture_' . $order->id . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'affichage de la facture: ' . $e->getMessage());
        }
    }
}

