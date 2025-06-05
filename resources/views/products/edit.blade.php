@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f5fe; 
        margin: 0;
        padding: 0;
    }

    .header {
        text-align: center;
        margin: 30px 0;
    }

    .header h1 {
        font-size: 32px;
        color: #6c4ce8; 
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        background: #ffffff; 
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-size: 16px;
        color: #6c4ce8; 
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        color: #555;
        background-color: #f7f5fe; 
        border: 1px solid #d5d2f0; 
        border-radius: 8px;
        margin-bottom: 20px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #6c4ce8; 
        outline: none;
    }

    .btn-primary {
        display: block;
        width: 100%;
        padding: 10px;
        background: #6c4ce8;
        color: #ffffff;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background: #5233c7; 
    }

    .form-group {
        margin-bottom: 20px;
    }
</style>

<div class="header">
    <h1>Edit Product</h1>
</div>

<div class="container">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div class="form-group">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>
<!-- Category Dropdown -->
<div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <select id="category" name="category" class="form-control" required>
        <option value="">Select Category</option>
        <option value="calligraphy" {{ old('category', $product->category) == 'calligraphy' ? 'selected' : '' }}>Calligraphy</option>
        <option value="resin_art" {{ old('category', $product->category) == 'resin_art' ? 'selected' : '' }}>Resin Art</option>
        <option value="abstract_art" {{ old('category', $product->category) == 'abstract_art' ? 'selected' : '' }}>Abstract Art</option>
        <option value="digital_art" {{ old('category', $product->category) == 'digital_art' ? 'selected' : '' }}>Digital Art</option>
        <option value="painting" {{ old('category', $product->category) == 'painting' ? 'selected' : '' }}>Painting</option>
        <option value="faceless_portraits" {{ old('category', $product->category) == 'faceless_portraits' ? 'selected' : '' }}>Faceless Portraits</option>
        <option value="landscape" {{ old('category', $product->category) == 'landscape' ? 'selected' : '' }}>Landscape</option>
        <option value="fabric_painting" {{ old('category', $product->category) == 'fabric_painting' ? 'selected' : '' }}>Fabric Painting</option>
    </select>
</div>
        <!-- Description -->
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        <!-- Image Upload (Optional) -->
        <div class="form-group">
            <label for="image" class="form-label">Upload Image (Leave empty to keep current image)</label>
            <input type="file" id="image" name="image" class="form-control">
            @if($product->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100px; height: auto; border-radius: 8px;">
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-primary">Update Product</button>
    </form>
</div>
@endsection
