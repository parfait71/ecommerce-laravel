@extends('layouts.admin')

@section('title', 'Éditer un produit')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Modifier le produit
                    </h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Informations de base -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-tag me-2"></i>Nom du produit
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control" 
                                           value="{{ old('name', $product->name) }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label fw-bold">
                                                <i class="fas fa-folder me-2"></i>Catégorie
                                            </label>
                                            <select name="category_id" id="category_id" class="form-select" required>
                                                <option value="">Sélectionner une catégorie</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label fw-bold">
                                                <i class="fas fa-money-bill me-2"></i>Prix (FCFA)
                                            </label>
                                            <input type="number" name="price" id="price" class="form-control" 
                                                   step="0.01" value="{{ old('price', $product->price) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock" class="form-label fw-bold">
                                                <i class="fas fa-boxes me-2"></i>Stock
                                            </label>
                                            <input type="number" name="stock" id="stock" class="form-control" 
                                                   value="{{ old('stock', $product->stock) }}" required min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i>Nouvelle image principale
                                            </label>
                                            <input type="file" name="image" id="image" class="form-control" 
                                                   accept="image/*" onchange="previewImage(this, 'mainImagePreview')">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">
                                        <i class="fas fa-align-left me-2"></i>Description
                                    </label>
                                    <textarea name="description" id="description" class="form-control" 
                                              rows="4">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Image principale actuelle -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Image principale actuelle</label>
                                    <div id="mainImagePreview" class="image-preview-container">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="Image principale" class="img-fluid">
                                        @else
                                            <div class="image-placeholder">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                                <p class="text-muted mt-2">Aucune image</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Images multiples existantes -->
                                @if($product->images->count() > 0)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Images supplémentaires actuelles</label>
                                        <div class="row g-2">
                                            @foreach($product->images as $image)
                                                <div class="col-6">
                                                    <div class="preview-thumbnail">
                                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                             alt="Image {{ $loop->iteration }}">
                                                        <button type="button" class="remove-image" 
                                                                onclick="deleteProductImage({{ $product->id }}, {{ $image->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Nouvelles images multiples -->
                                <div class="mb-3">
                                    <label for="images" class="form-label fw-bold">
                                        <i class="fas fa-images me-2"></i>Ajouter des images
                                    </label>
                                    <input type="file" name="images[]" id="images" class="form-control" 
                                           multiple accept="image/*" onchange="previewMultipleImages(this)">
                                </div>

                                <!-- Prévisualisation des nouvelles images -->
                                <div id="multipleImagesPreview" class="row g-2">
                                    <!-- Les prévisualisations seront ajoutées ici -->
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-warning" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.image-preview-container {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.image-preview-container:hover {
    border-color: #ffc107;
    background: #fff3cd;
}

.image-preview-container img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.image-placeholder {
    color: #6c757d;
}

.preview-thumbnail {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.preview-thumbnail img {
    width: 100%;
    height: 80px;
    object-fit: cover;
}

.remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-image:hover {
    background: #dc3545;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1.5rem;
}

.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}
</style>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Prévisualisation" class="img-fluid">`;
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        // Restaurer l'image originale si elle existe
        @if($product->image)
            preview.innerHTML = `<img src="{{ asset('storage/' . $product->image) }}" alt="Image principale" class="img-fluid">`;
        @else
            preview.innerHTML = `
                <div class="image-placeholder">
                    <i class="fas fa-image fa-3x text-muted"></i>
                    <p class="text-muted mt-2">Aucune image</p>
                </div>
            `;
        @endif
    }
}

function previewMultipleImages(input) {
    const preview = document.getElementById('multipleImagesPreview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const thumbnail = document.createElement('div');
                thumbnail.className = 'col-6 preview-thumbnail';
                thumbnail.innerHTML = `
                    <img src="${e.target.result}" alt="Image ${index + 1}">
                    <button type="button" class="remove-image" onclick="removeImage(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                preview.appendChild(thumbnail);
            };
            
            reader.readAsDataURL(file);
        });
    }
}

function removeImage(index) {
    const input = document.getElementById('images');
    const dt = new DataTransfer();
    
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    previewMultipleImages(input);
}

function deleteProductImage(productId, imageId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        fetch(`/admin/products/${productId}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la suppression de l\'image');
        });
    }
}

// Validation du formulaire
document.getElementById('productForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mise à jour en cours...';
    submitBtn.disabled = true;
    
    // Réactiver le bouton après 5 secondes au cas où
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});
</script>
@endsection
