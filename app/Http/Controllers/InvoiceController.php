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
            \Log::info('Tentative de téléchargement de facture pour la commande ' . $order->id);
            $invoice = $order->invoice;
            if (!$invoice || !$invoice->pdf_path) {
                \Log::warning('Aucune facture ou chemin PDF pour la commande ' . $order->id . ', génération...');
                $invoice = $this->invoiceService->generateInvoice($order);
            }
            $path = storage_path('app/public/' . $invoice->pdf_path);
            if (!file_exists($path)) {
                \Log::error('Fichier PDF manquant après génération pour la commande ' . $order->id . ' : ' . $path);
                $invoice = $this->invoiceService->generateInvoice($order);
                $path = storage_path('app/public/' . $invoice->pdf_path);
                if (!file_exists($path)) {
                    \Log::critical('Impossible de générer le PDF pour la commande ' . $order->id);
                    return response('Erreur : Le fichier PDF de la facture n\'a pas pu être généré. Veuillez réessayer ou contacter le support.', 500);
                }
            }
            \Log::info('Téléchargement du PDF pour la commande ' . $order->id . ' : ' . $path);
            return response()->download($path, 'facture_' . $order->id . '.pdf');
        } catch (\Exception $e) {
            \Log::error('Exception lors du téléchargement de la facture : ' . $e->getMessage());
            return response('Erreur lors du téléchargement de la facture: ' . $e->getMessage(), 500);
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

