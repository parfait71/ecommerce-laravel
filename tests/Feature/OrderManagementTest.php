<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un utilisateur normal
        $this->user = User::factory()->create([
            'is_admin' => false
        ]);
        
        // Créer une catégorie et un produit
        $category = Category::create([
            'name' => 'Test Category',
            'description' => 'Test category'
        ]);
        
        $this->product = Product::create([
            'name' => 'Test Product',
            'description' => 'Test product description',
            'price' => 15000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);
    }

    /** @test */
    public function user_can_add_product_to_cart()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $cart = session('cart');
        $this->assertNotNull($cart);
        $this->assertArrayHasKey($this->product->id, $cart);
        $this->assertEquals(2, $cart[$this->product->id]['quantity']);
    }

    /** @test */
    public function user_can_create_order_with_online_payment()
    {
        $this->actingAs($this->user);

        // Ajouter un produit au panier
        Session::put('cart', [
            $this->product->id => [
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => 2,
            ]
        ]);

        $response = $this->post(route('orders.store'), [
            'address' => '123 Test Street, Test City',
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

        // Vérifier que le panier a été vidé
        $this->assertNull(session('cart'));
    }

    /** @test */
    public function user_can_create_order_with_cash_on_delivery()
    {
        $this->actingAs($this->user);

        // Ajouter un produit au panier
        Session::put('cart', [
            $this->product->id => [
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => 1,
            ]
        ]);

        $response = $this->post(route('orders.store'), [
            'address' => '456 Delivery Street, Delivery City',
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
        $response->assertSessionHas('success');

        // Vérifier que la commande a été créée
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'total' => $this->product->price,
            'status' => 'en attente',
            'payment_status' => 'non payé',
        ]);

        // Vérifier que le paiement a été créé
        $order = Order::where('user_id', $this->user->id)->first();
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'method' => 'paiement à la livraison',
            'status' => 'non payé',
        ]);
    }

    /** @test */
    public function admin_cannot_create_orders()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->post(route('orders.store'), [
            'address' => 'Test Address',
            'payment_method' => 'paiement en ligne',
            'cart' => [],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function order_validation_works()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('orders.store'), [
            'address' => '', // Adresse vide
            'payment_method' => 'invalid_method', // Méthode invalide
            'cart' => [], // Panier vide
        ]);

        $response->assertSessionHasErrors(['address', 'payment_method', 'cart']);
    }

    /** @test */
    public function user_can_view_their_orders()
    {
        $this->actingAs($this->user);

        // Créer une commande
        $order = Order::create([
            'user_id' => $this->user->id,
            'total' => 15000,
            'status' => 'en attente',
            'payment_status' => 'non payé',
        ]);

        $response = $this->get(route('orders.index'));

        $response->assertStatus(200);
        $response->assertSee($order->id);
    }

    /** @test */
    public function user_can_view_specific_order()
    {
        $this->actingAs($this->user);

        $order = Order::create([
            'user_id' => $this->user->id,
            'total' => 15000,
            'status' => 'en attente',
            'payment_status' => 'non payé',
        ]);

        $response = $this->get(route('orders.show', $order->id));

        $response->assertStatus(200);
        $response->assertSee($order->id);
    }

    /** @test */
    public function user_cannot_view_other_user_orders()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($this->user);

        $order = Order::create([
            'user_id' => $otherUser->id,
            'total' => 15000,
            'status' => 'en attente',
            'payment_status' => 'non payé',
        ]);

        $response = $this->get(route('orders.show', $order->id));

        $response->assertStatus(403);
    }
} 