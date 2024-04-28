<section class="admin-section">
    <h1>Admin Dashboard</h1>

    <h2>Add New Product</h2>
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>
        <div>
            <label for="care_level">Care Level:</label>
            <select id="care_level" name="care_level">
                <option value="1">Low</option>
                <option value="2">Medium</option>
                <option value="3">High</option>
            </select>
        </div>
        <div>
            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" required>
        </div>
        <div>
            <label for="info">Info:</label>
            <textarea id="info" name="info"></textarea>
        </div>
        <div>
            <label for="image">Product Image:</label>
            <input type="file" id="image" name="image" required>
        </div>
        <div>
            <button type="submit">Add Product</button>
        </div>
    </form>

    <div class="products-table">
        <table>
            <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Care Level</th>
                <th>Stock Quantity</th>
                <th>Info</th>
                <th>Categories</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;"></td>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->care_level }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>{{ $product->info }}</td>
                    <td>
                        @foreach ($product->categories as $category)
                            <span class="badge">{{ $category->name }}
                            <form method="POST" action="{{ route('admin.categories.remove', ['id' => $product->id]) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                <button type="submit" style="background: none; border: none; color: red; font-size: small;">x</button>
                            </form>
                        </span>
                        @endforeach
                        <form method="POST" action="{{ route('admin.categories.add') }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="text" name="category_name" placeholder="Add category" required>
                            <button type="submit">Add</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $product->name }}" required>
                            <input type="number" name="price" value="{{ $product->price }}" step="0.01" required>
                            <select name="care_level">
                                <option value="1" {{ $product->care_level == 1 ? 'selected' : '' }}>Low</option>
                                <option value="2" {{ $product->care_level == 2 ? 'selected' : '' }}>Medium</option>
                                <option value="3" {{ $product->care_level == 3 ? 'selected' : '' }}>High</option>
                            </select>
                            <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" required>
                            <textarea name="info">{{ $product->info }}</textarea>
                            <input type="file" name="image">
                            <button type="submit">Update</button>
                        </form>
                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

<style>
    .admin-section { padding: 20px; }
    .products-table { margin-top: 20px; }
    .products-table table { width: 100%; border-collapse: collapse; }
    .products-table th, .products-table td { border: 1px solid #ccc; padding: 8px; text-align left; }
    .badge { background-color: #e2e2e2; border-radius: 5px; padding: 2px 8px; display: inline-block; margin-right: 5px; }
</style>
