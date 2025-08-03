<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'description', 'price', 'stock', 'category_id']);
        
        // Gestion de l'image principale
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'products');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        // Gestion des images multiples
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $this->uploadImage($image, 'products');
                $product->images()->create(['image_path' => $imagePath]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit modifié avec succès.');
    }

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        // Supprimer les images associées
        foreach ($product->images as $image) {
            $this->deleteImage($image->image_path);
        }
        
        // Supprimer l'image principale si elle existe
        if ($product->image) {
            $this->deleteImage($product->image);
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'description', 'price', 'stock', 'category_id']);
        
        // Gestion de l'image principale
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'products');
            $data['image'] = $imagePath;
        }

        $product = Product::create($data);

        // Gestion des images multiples
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $this->uploadImage($image, 'products');
                $product->images()->create(['image_path' => $imagePath]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit ajouté avec succès.');
    }

    // Supprimer une image spécifique
    public function deleteProductImage($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);
        
        $this->deleteImage($image->image_path);
        $image->delete();
        
        return response()->json(['success' => true]);
    }

    // Récupérer les images d'un produit
    public function getImages($productId)
    {
        $product = Product::with('images')->findOrFail($productId);
        
        return response()->json([
            'success' => true,
            'images' => $product->images
        ]);
    }

    // Méthodes privées pour la gestion des images
    private function uploadImage($file, $folder)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');
        
        // Redimensionner l'image si nécessaire
        $this->resizeImage($path);
        
        return $path;
    }

    private function resizeImage($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        
        if (file_exists($fullPath)) {
            $image = Image::make($fullPath);
            
            // Redimensionner si l'image est trop grande
            if ($image->width() > 800 || $image->height() > 800) {
                $image->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            $image->save($fullPath, 85); // Qualité 85%
        }
    }

    private function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
} 