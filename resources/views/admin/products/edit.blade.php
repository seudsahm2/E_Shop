<link rel="stylesheet" href="{{ asset('css/admin/create.css') }}">

<div class="container">
    <h1>Edit Product</h1>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ $product->description }}</textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="{{ $product->price }}" required>
        </div>
        <div>
            <label for="cost">Cost:</label>
            <input type="number" id="cost" name="cost" step="0.01" value="{{ $product->cost }}" required>
        </div>
        <div>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
        </div>
        <div class="category-field">
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="brand-field">
            <label for="brand_id">Brand:</label>
            <select id="brand_id" name="brand_id" required>
                @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="color-field">
            <label>Colors:</label>
            <select id="colors" name="colors[]" multiple required>
                @foreach($colors as $color)
                <option value="{{ $color->id }}" {{ in_array($color->id, $product->colors->pluck('id')->toArray()) ? 'selected' : '' }} style="background-color: {{ $color->hex_code }}; color: #fff;">
                    {{ $color->name }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Update Product</button>
    </form>
</div>