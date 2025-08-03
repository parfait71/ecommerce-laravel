<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Services\EmailService;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailAndInvoiceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $order;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configurer le fake pour les emails et le storage
        Mail::fake();
        Storage::fake('public');
        
        // Créer un utilisateur
        $this->user = User::factory()->create([
            'email' => 'test@example.com'
        ]);
        
        // Créer une catégorie et un produit
        $category = Category::create([
            'name' => 'Test Category',
            'description' => 'Test category'
        ]);
        
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'Test product description',
            'price' => 15000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);
        
        // Créer une commande
        $this->order = Order::create([
            'user_id' => $this->user->id,
            'total' => 15000,
            'status' => 'en attente',
            'payment_status' => 'non payé',
        ]);
        
        // Créer un paiement
        Payment::create([
            'order_id' => $this->order->id,
            'method' => 'paiement en ligne',
            'status' => 'non payé',
        ]);
    }

    /** @test */
    public function email_service_can_send_order_confirmation()
    {
        $emailService = new EmailService();
        
        $result = $emailService->sendOrderConfirmation($this->order);
        
        $this->assertTrue($result);
        
        // Vérifier que l'email a été envoyé
        Mail::assertSent(\App\Mail\OrderConfirmation::class, function ($mail) {
            return $mail->hasTo($this->user->email);
        });
    }

    /** @test */
    public function invoice_service_can_generate_invoice()
    {
        $invoiceService = new InvoiceService();
        
        $invoice = $invoiceService->generateInvoice($this->order);
        
        $this->assertNotNull($invoice);
        $this->assertEquals($this->order->id, $invoice->order_id);
        $this->assertNotNull($invoice->pdf_path);
        
        // Vérifier que le fichier PDF a été créé
        Storage::disk('public')->assertExists($invoice->pdf_path);
    }

    /** @test */
    public function invoice_service_can_download_invoice()
    {
        $invoiceService = new InvoiceService();
        
        $path = $invoiceService->downloadInvoice($this->order);
        
        $this->assertFileExists($path);
        $this->assertStringEndsWith('.pdf', $path);
    }

    /** @test */
    public function email_service_can_send_invoice_email()
    {
        $invoiceService = new InvoiceService();
        $invoice = $invoiceService->generateInvoice($this->order);
        
        $emailService = new EmailService();
        $result = $emailService->sendInvoiceEmail($this->order, $invoice);
        
        $this->assertTrue($result);
        
        // Vérifier que l'email avec facture a été envoyé
        Mail::assertSent(\App\Mail\InvoiceEmail::class, function ($mail) {
            return $mail->hasTo($this->user->email);
        });
    }

    /** @test */
    public function email_service_can_send_invoice_automatically()
    {
        $emailService = new EmailService();
        
        $result = $emailService->sendInvoiceAutomatically($this->order);
        
        $this->assertTrue($result);
        
        // Vérifier que l'email a été envoyé
        Mail::assertSent(\App\Mail\InvoiceEmail::class);
    }

    /** @test */
    public function order_creation_triggers_confirmation_email()
    {
        $this->actingAs($this->user);
        
        // Simuler un panier
        session(['cart' => [
            1 => [
                'product_id' => 1,
                'name' => 'Test Product',
                'price' => 15000,
                'quantity' => 1,
            ]
        ]]);
        
        $response = $this->post(route('orders.store'), [
            'address' => 'Test Address',
            'payment_method' => 'paiement en ligne',
            'cart' => [
                [
                    'product_id' => 1,
                    'quantity' => 1,
                    'price' => 15000,
                ]
            ],
        ]);
        
        $response->assertRedirect();
        
        // Vérifier que l'email de confirmation a été envoyé
        Mail::assertSent(\App\Mail\OrderConfirmation::class);
    }

    /** @test */
    public function invoice_generation_creates_pdf_file()
    {
        $invoiceService = new InvoiceService();
        
        $invoice = $invoiceService->generateInvoice($this->order);
        
        // Vérifier que le fichier PDF existe
        $fullPath = storage_path('app/public/' . $invoice->pdf_path);
        $this->assertFileExists($fullPath);
        
        // Vérifier que c'est bien un fichier PDF
        $this->assertStringEndsWith('.pdf', $fullPath);
        
        // Vérifier que le fichier n'est pas vide
        $this->assertGreaterThan(0, filesize($fullPath));
    }

    /** @test */
    public function invoice_service_handles_missing_invoice()
    {
        $invoiceService = new InvoiceService();
        
        // Supprimer l'invoice s'il existe
        $this->order->invoice()->delete();
        
        $invoice = $invoiceService->generateInvoice($this->order);
        
        $this->assertNotNull($invoice);
        $this->assertEquals($this->order->id, $invoice->order_id);
    }

    /** @test */
    public function email_service_handles_errors_gracefully()
    {
        // Simuler une erreur en modifiant l'email
        $this->order->user->update(['email' => 'invalid-email']);
        
        $emailService = new EmailService();
        $result = $emailService->sendOrderConfirmation($this->order);
        
        // Le service devrait gérer l'erreur et retourner false
        $this->assertFalse($result);
    }
} 