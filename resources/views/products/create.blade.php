<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Produk</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>

<div class="container-fluid mt-4">

    <h1 class="h3 mb-4 text-gray-800">Tambah Produk</h1>

    <div class="card shadow">

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

            <form action="{{ route('products.store') }}" method="POST">

                @csrf

                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label>SKU</label>
                    <input type="text"
                           name="sku"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="number"
                           name="price"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <input type="number"
                           name="stock"
                           class="form-control"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan
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