@extends('layouts.admin')

@section('title', 'Ajouter un produit')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus me-2"></i>Ajouter un nouveau produit
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

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Informations de base -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">
                                        <i class="fas fa-tag me-2"></i>Nom du produit
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control" 
                                           value="{{ old('name') }}" required 
                                           placeholder="Ex: iPhone 15 Pro">
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
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                                   step="0.01" value="{{ old('price') }}" required 
                                                   placeholder="0.00">
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
                                                   value="{{ old('stock') }}" required min="0" 
                                                   placeholder="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label fw-bold">
                                                <i class="fas fa-image me-2"></i>Image principale
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
                                              rows="4" placeholder="Description détaillée du produit...">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Prévisualisation de l'image principale -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Image principale</label>
                                    <div id="mainImagePreview" class="image-preview-container">
                                        <div class="image-placeholder">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                            <p class="text-muted mt-2">Aucune image sélectionnée</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Images multiples -->
                                <div class="mb-3">
                                    <label for="images" class="form-label fw-bold">
                                        <i class="fas fa-images me-2"></i>Images supplémentaires
                                    </label>
                                    <input type="file" name="images[]" id="images" class="form-control" 
                                           multiple accept="image/*" onchange="previewMultipleImages(this)">
                                </div>

                                <!-- Prévisualisation des images multiples -->
                                <div id="multipleImagesPreview" class="row g-2">
                                    <!-- Les prévisualisations seront ajoutées ici -->
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-success" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Créer le produit
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
    border-color: #007bff;
    background: #e3f2fd;
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
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
        preview.innerHTML = `
            <div class="image-placeholder">
                <i class="fas fa-image fa-3x text-muted"></i>
                <p class="text-muted mt-2">Aucune image sélectionnée</p>
            </div>
        `;
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

// Validation du formulaire
document.getElementById('productForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création en cours...';
    submitBtn.disabled = true;
    
    // Réactiver le bouton après 5 secondes au cas où
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});
</script>
@endsection 