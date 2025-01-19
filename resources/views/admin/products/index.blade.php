<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title  -->
    <title>Admin - Product List</title>

    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
</head>

<body>
    <div class="container">
        <h1>Products</h1>
        <!-- Add Product Button -->
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

        <!-- Product Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Colors</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50"></td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>
                        <ul class="color-list">
                            @foreach($product->colors as $color)
                            <li style="background-color: #{{ $color->hex_code }};"></li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>