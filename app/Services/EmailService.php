<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use App\Mail\OrderConfirmation;
use App\Mail\InvoiceEmail;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Envoyer un email de confirmation de commande
     */
    public function sendOrderConfirmation(Order $order)
    {
        try {
            Mail::to($order->user->email)->send(new OrderConfirmation($order));
            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email confirmation commande: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Envoyer un email avec facture en pièce jointe
     */
    public function sendInvoiceEmail(Order $order, Invoice $invoice)
    {
        try {
            Mail::to($order->user->email)->send(new InvoiceEmail($order, $invoice));
            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email facture: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Envoyer automatiquement la facture après génération
     */
    public function sendInvoiceAutomatically(Order $order)
    {
        $invoice = $order->invoice;
        
        if (!$invoice) {
            // Générer la facture si elle n'existe pas
            $invoiceService = new InvoiceService();
            $invoice = $invoiceService->generateInvoice($order);
        }

        return $this->sendInvoiceEmail($order, $invoice);
    }
} 