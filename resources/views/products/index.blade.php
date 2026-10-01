<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Produk</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>

<div class="container-fluid mt-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Produk</h1>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Produk
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>SKU</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($products as $product)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $product->name }}</td>

                            <td>{{ $product->sku }}</td>

                            <td>
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <td>{{ $product->stock }}</td>

                            <td>

                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}"
                                      method="POST"
                                      style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>

                                </form>

                            </td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>