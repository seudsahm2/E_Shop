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
        <h1>Product List</h1>

        <!-- Add Product Button -->
        <a href="{{ route('admin.products.create') }}" class="btn">Add New Product</a>

        <!-- Product Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th> <!-- Add Quantity Column -->
                    <th>Description</th>
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
                    <td>{{ $product->quantity }}</td> <!-- Display Quantity -->
                    <td>{{ $product->description }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>