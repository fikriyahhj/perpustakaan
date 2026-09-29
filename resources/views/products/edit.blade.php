<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Produk</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>

<div class="container-fluid mt-4">

    <h1 class="h3 mb-4 text-gray-800">Edit Produk</h1>

    <div class="card shadow">

        <div class="card-body">

            <form action="{{ route('products.update', $product->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ $product->name }}"
                           required>
                </div>

                <div class="form-group">
                    <label>SKU</label>
                    <input type="text"
                           name="sku"
                           class="form-control"
                           value="{{ $product->sku }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number"
                           name="price"
                           class="form-control"
                           value="{{ $product->price }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number"
                           name="stock"
                           class="form-control"
                           value="{{ $product->stock }}"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('products.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>