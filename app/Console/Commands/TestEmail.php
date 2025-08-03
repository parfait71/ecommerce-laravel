<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Services\EmailService;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {order_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester l\'envoi d\'emails pour une commande';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        if (!$orderId) {
            $order = Order::with(['user', 'orderItems.product', 'payment'])->first();
            if (!$order) {
                $this->error('Aucune commande trouvée.');
                return 1;
            }
        } else {
            $order = Order::with(['user', 'orderItems.product', 'payment'])->find($orderId);
            if (!$order) {
                $this->error('Commande non trouvée.');
                return 1;
            }
        }

        $this->info("Test d'envoi d'email pour la commande #{$order->id}");

        $emailService = new EmailService();
        
        // Test email de confirmation
        $this->info('Envoi email de confirmation...');
        $result = $emailService->sendOrderConfirmation($order);
        
        if ($result) {
            $this->info('✅ Email de confirmation envoyé avec succès !');
        } else {
            $this->error('❌ Erreur lors de l\'envoi de l\'email de confirmation');
        }

        // Test email avec facture
        $this->info('Envoi email avec facture...');
        $result = $emailService->sendInvoiceAutomatically($order);
        
        if ($result) {
            $this->info('✅ Email avec facture envoyé avec succès !');
        } else {
            $this->error('❌ Erreur lors de l\'envoi de l\'email avec facture');
        }

        return 0;
    }
} 