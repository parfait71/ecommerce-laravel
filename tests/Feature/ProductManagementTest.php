<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer un admin
        $this->admin = User::factory()->create([
            'is_admin' => true
        ]);
        
        // Créer une catégorie
        $this->category = Category::create([
            'name' => 'Test Category',
            'description' => 'Test category description'
        ]);
        
        // Configurer le storage pour les tests
        Storage::fake('public');
    }

    /** @test */
    public function admin_can_create_product_with_image()
    {
        $this->actingAs($this->admin);

        $image = UploadedFile::fake()->image('product.jpg', 800, 600);

        $response = $this->post(route('admin.products.store'), [
            'name' => 'Test Product',
            'description' => 'Test product description',
            'price' => 15000,
            'stock' => 10,
            'category_id' => $this->category->id,
            'image' => $image,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 15000,
            'stock' => 10,
            'category_id' => $this->category->id,
        ]);

        // Vérifier que l'image a été uploadée
        $product = Product::where('name', 'Test Product')->first();
        $this->assertNotNull($product->image);
        Storage::disk('public')->assertExists($product->image);
    }

    /** @test */
    public function admin_can_update_product()
    {
        $this->actingAs($this->admin);

        $product = Product::create([
            'name' => 'Original Product',
            'description' => 'Original description',
            'price' => 10000,
            'stock' => 5,
            'category_id' => $this->category->id,
        ]);

        $response = $this->put(route('admin.products.update', $product->id), [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 20000,
            'stock' => 15,
            'category_id' => $this->category->id,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 20000,
            'stock' => 15,
        ]);
    }

    /** @test */
    public function admin_can_delete_product()
    {
        $this->actingAs($this->admin);

        $product = Product::create([
            'name' => 'Product to Delete',
            'description' => 'Description',
            'price' => 10000,
            'stock' => 5,
            'category_id' => $this->category->id,
        ]);

        $response = $this->delete(route('admin.products.destroy', $product->id));

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function non_admin_cannot_access_product_management()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user);

        $response = $this->get(route('admin.products.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function product_validation_works()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.products.store'), [
            'name' => '', // Nom vide
            'price' => -100, // Prix négatif
            'stock' => -5, // Stock négatif
            'category_id' => 999, // Catégorie inexistante
        ]);

        $response->assertSessionHasErrors(['name', 'price', 'stock', 'category_id']);
    }
} 