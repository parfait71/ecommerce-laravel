<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CompleteSystemTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $category;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configuration des fakes
        Storage::fake('public');
        Mail::fake();
        
        // Créer un admin
        $this->admin = User::factory()->create([
            'is_admin' => true,
            'email' => 'admin@eazystore.com'
        ]);
        
        // Créer un utilisateur normal
        $this->user = User::factory()->create([
            'is_admin' => false,
            'email' => 'user@eazystore.com'
        ]);
        
        // Créer une catégorie
        $this->category = Category::create([
            'name' => 'Électronique',
            'description' => 'Produits électroniques'
        ]);
        
        // Créer un produit
        $this->product = Product::create([
            'name' => 'iPhone 15 Pro',
            'description' => 'Le dernier iPhone avec des fonctionnalités avancées',
            'price' => 450000,
            'stock' => 10,
            'category_id' => $this->category->id,
        ]);
    }

    /** @test */
    public function complete_ecommerce_workflow()
    {
        // 1. Admin crée un produit avec image
        $this->actingAs($this->admin);
        
        $image = UploadedFile::fake()->image('iphone.jpg', 800, 600);
        
        $response = $this->post(route('admin.products.store'), [
            'name' => 'Samsung Galaxy S24',
            'description' => 'Smartphone Android haut de gamme',
            'price' => 350000,
            'stock' => 15,
            'category_id' => $this->category->id,
            'image' => $image,
        ]);
        
        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');
        
        // Vérifier que le produit a été créé
        $this->assertDatabaseHas('products', [
            'name' => 'Samsung Galaxy S24',
            'price' => 350000,
            'stock' => 15,
        ]);
        
        // 2. Utilisateur ajoute un produit au panier
        $this->actingAs($this->user);
        
        $response = $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // Vérifier que le panier contient le produit
        $cart = session('cart');
        $this->assertNotNull($cart);
        $this->assertArrayHasKey($this->product->id, $cart);
        $this->assertEquals(2, $cart[$this->product->id]['quantity']);
        
        // 3. Utilisateur passe une commande avec paiement en ligne
        $response = $this->post(route('orders.store'), [
            'address' => '123 Rue de la Paix, Abidjan, Côte d\'Ivoire',
            'payment_method' => 'paiement en ligne',
            'cart' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 2,
                    'price' => $this->product->price,
                ]
            ],
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // Vérifier que la commande a été créée
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'total' => $this->product->price * 2,
            'status' => 'en attente',
            'payment_status' => 'non payé',
        ]);
        
        // Vérifier que le paiement a été créé
        $order = Order::where('user_id', $this->user->id)->first();
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'method' => 'paiement en ligne',
            'status' => 'non payé',
        ]);
        
        // 4. Vérifier que l'email de confirmation a été envoyé
        Mail::assertSent(\App\Mail\OrderConfirmation::class, function ($mail) {
            return $mail->hasTo($this->user->email);
        });
        
        // 5. Admin peut voir la commande dans le back-office
        $this->actingAs($this->admin);
        
        $response = $this->get(route('admin.orders.index'));
        $response->assertStatus(200);
        $response->assertSee($order->id);
        
        // 6. Admin peut marquer la commande comme payée
        $response = $this->post(route('admin.orders.mark-as-paid', $order->id));
        $response->assertRedirect();
        
        // Vérifier que le statut a été mis à jour
        $order->refresh();
        $this->assertEquals('payé', $order->payment->status);
        
        // 7. Utilisateur peut voir sa commande
        $this->actingAs($this->user);
        
        $response = $this->get(route('orders.index'));
        $response->assertStatus(200);
        $response->assertSee($order->id);
        
        // 8. Utilisateur peut télécharger sa facture
        $response = $this->get(route('invoice.download', $order->id));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function admin_can_access_analytics_dashboard()
    {
        $this->actingAs($this->admin);
        
        $response = $this->get(route('admin.analytics.dashboard'));
        
        $response->assertStatus(200);
        $response->assertSee('Analytics Avancé');
        $response->assertSee('Chiffre d\'affaires total');
        $response->assertSee('Commandes totales');
    }

    /** @test */
    public function admin_can_export_analytics_data()
    {
        $this->actingAs($this->admin);
        
        // Test export PDF
        $response = $this->get(route('admin.analytics.export.pdf'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        
        // Test export Excel
        $response = $this->get(route('admin.analytics.export.excel'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function user_cannot_access_admin_features()
    {
        $this->actingAs($this->user);
        
        // Essayer d'accéder au dashboard admin
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(403);
        
        // Essayer d'accéder à la gestion des produits
        $response = $this->get(route('admin.products.index'));
        $response->assertStatus(403);
        
        // Essayer d'accéder aux analytics
        $response = $this->get(route('admin.analytics.dashboard'));
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_protected_features()
    {
        // Essayer d'accéder au panier sans être connecté
        $response = $this->get(route('cart.index'));
        $response->assertRedirect(route('login'));
        
        // Essayer d'ajouter au panier sans être connecté
        $response = $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);
        $response->assertRedirect(route('login'));
        
        // Essayer de passer une commande sans être connecté
        $response = $this->post(route('orders.store'), [
            'address' => 'Test Address',
            'payment_method' => 'paiement en ligne',
            'cart' => [],
        ]);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function system_handles_edge_cases()
    {
        // Test avec un panier vide
        $this->actingAs($this->user);
        
        $response = $this->post(route('orders.store'), [
            'address' => 'Test Address',
            'payment_method' => 'paiement en ligne',
            'cart' => [],
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('error');
        
        // Test avec un produit en rupture de stock
        $this->product->update(['stock' => 0]);
        
        $response = $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function payment_methods_work_correctly()
    {
        $this->actingAs($this->user);
        
        // Test paiement en ligne
        Session::put('cart', [
            $this->product->id => [
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => 1,
            ]
        ]);
        
        $response = $this->post(route('orders.store'), [
            'address' => 'Test Address',
            'payment_method' => 'paiement en ligne',
            'cart' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 1,
                    'price' => $this->product->price,
                ]
            ],
        ]);
        
        $response->assertRedirect();
        
        $order = Order::where('user_id', $this->user->id)->first();
        $this->assertEquals('paiement en ligne', $order->payment->method);
        
        // Test paiement à la livraison
        Session::put('cart', [
            $this->product->id => [
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => 1,
            ]
        ]);
        
        $response = $this->post(route('orders.store'), [
            'address' => 'Test Address',
            'payment_method' => 'paiement à la livraison',
            'cart' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 1,
                    'price' => $this->product->price,
                ]
            ],
        ]);
        
        $response->assertRedirect();
        
        $order = Order::where('user_id', $this->user->id)->orderBy('id', 'desc')->first();
        $this->assertEquals('paiement à la livraison', $order->payment->method);
    }
} 