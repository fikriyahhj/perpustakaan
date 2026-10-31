<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kasir</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #f8f9fc;
        }

        .kasir-header {
            background: #4e73df;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .kasir-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0,0,0,.08);
            margin-bottom: 15px;
        }

        .cart-table th,
        .cart-table td {
            vertical-align: middle;
        }

        .summary-box {
            background: #f8f9fc;
            border-radius: 8px;
            padding: 15px;
        }

        .grand-total {
            font-size: 24px;
            font-weight: bold;
        }

        /* STRUK TIDAK TAMPIL DI HALAMAN KASIR */
        #struk {
            display: block !important;
            width: 100%;
            margin: 0;
            padding: 30px 50px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: black;
        }

        /* TAMPILAN SAAT PRINT */
        @media print {

            body {
                background: white;
                margin: 0;
            }

            body > * {
                display: none !important;
            }

            #struk {
                display: block !important;
                width: 300px;
                margin: 0 auto;
                padding: 10px;
                font-family: Arial, sans-serif;
                font-size: 12px;
                color: black;
            }

            #struk h3 {
                text-align: center;
                margin-bottom: 5px;
            }

            #struk p {
                margin: 5px 0;
            }

            #struk .judul-struk {
                text-align: center;
            }

            #struk .total-struk {
                font-size: 16px;
                font-weight: bold;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid mt-4">

    <!-- HEADER -->
    <div class="kasir-header">
        <div class="d-flex justify-content-between">

            <div>
                <h4 class="mb-1">Perpustakaan</h4>
                <small>Transaksi Penjualan</small>
            </div>

            <div class="text-right">
                <div>
                    No. Transaksi:
                    <strong id="noTransaksi"></strong>
                </div>

                <div>
                    Kasir:
                    <strong>{{ auth()->user()->name }}</strong>
                </div>

                <div id="tanggal"></div>
            </div>

        </div>
    </div>


    <div class="row">

        <!-- ================= BAGIAN KIRI ================= -->
        <div class="col-md-8">

            <div class="kasir-card">

                <!-- PENCARIAN -->
                <h6 class="font-weight-bold text-primary">
                    Cari Produk
                </h6>

                <div class="row mb-3">

                    <div class="col-md-8">
                        <input
                            type="text"
                            id="searchProduct"
                            class="form-control"
                            placeholder="Cari nama produk / kode produk..."
                        >
                    </div>

                    <div class="col-md-4">
                        <button
                            type="button"
                            class="btn btn-primary btn-block"
                            id="btnCari"
                        >
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                    </div>

                </div>


                <!-- DAFTAR PRODUK -->
                <div id="productList" class="mb-4">

                    @foreach($products as $product)

                        <button
                            type="button"
                            class="btn btn-outline-primary mr-2 mb-2 product-item"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-sku="{{ $product->sku }}"
                            data-price="{{ $product->price }}"
                        >

                            {{ $product->name }}

                            <br>

                            <small>
                                {{ $product->sku }}
                                -
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </small>

                        </button>

                    @endforeach

                </div>


                <!-- CUSTOMER -->
                <div class="form-group">

                    <label>Customer</label>

                    <input
                        type="text"
                        id="customer"
                        class="form-control"
                        placeholder="Nama customer"
                    >

                </div>


                <!-- KERANJANG -->
                <h6 class="font-weight-bold text-primary mt-4">
                    Keranjang Belanja
                </h6>


                <div class="table-responsive">

                    <table class="table table-bordered cart-table">

                        <thead>

                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th width="120">Qty</th>
                                <th>Total</th>
                                <th width="60">Aksi</th>
                            </tr>

                        </thead>


                        <tbody id="cartBody">

                            <!-- Produk akan masuk di sini -->

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- ================= BAGIAN KANAN ================= -->
        <div class="col-md-4">

            <div class="kasir-card">

                <h6 class="font-weight-bold text-primary">
                    Ringkasan Pembayaran
                </h6>


                <div class="summary-box">

                    <!-- JUMLAH ITEM -->
                    <div class="d-flex justify-content-between mb-2">

                        <span>
                            Jumlah Item
                        </span>

                        <strong id="itemCount">
                            0
                        </strong>

                    </div>


                    <!-- SUBTOTAL -->
                    <div class="d-flex justify-content-between mb-2">

                        <span>
                            Subtotal
                        </span>

                        <strong id="subtotal">
                            Rp 0
                        </strong>

                    </div>


                    <!-- DISKON -->
                    <div class="d-flex justify-content-between mb-2">

                        <span>
                            Diskon
                        </span>

                        <input
                            type="number"
                            id="discountInput"
                            class="form-control form-control-sm"
                            value="0"
                            min="0"
                            style="width: 120px;"
                        >

                    </div>


                    <!-- PAJAK -->
                    <div class="d-flex justify-content-between mb-2">

                        <span>
                            Pajak
                        </span>

                        <input
                            type="number"
                            id="taxInput"
                            class="form-control form-control-sm"
                            value="0"
                            min="0"
                            style="width: 120px;"
                        >

                    </div>


                    <!-- BIAYA LAIN -->
                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Biaya Lain
                        </span>

                        <input
                            type="number"
                            id="otherFeeInput"
                            class="form-control form-control-sm"
                            value="0"
                            min="0"
                            style="width: 120px;"
                        >

                    </div>


                    <hr>


                    <!-- GRAND TOTAL -->
                    <div class="d-flex justify-content-between">

                        <span>
                            Grand Total
                        </span>

                        <span
                            class="grand-total"
                            id="grandTotal"
                        >
                            Rp 0
                        </span>

                    </div>

                </div>


                <!-- PEMBAYARAN -->
                <div class="form-group mt-4">

                    <label>
                        Pembayaran
                    </label>

                    <input
                        type="number"
                        id="payment"
                        class="form-control"
                        placeholder="Masukkan jumlah pembayaran"
                        min="0"
                    >

                </div>


                <div class="form-group">

                    <label>
                        Metode Pembayaran
                    </label>

                    <select
                        id="paymentMethod"
                        class="form-control"
                    >

                        <option value="">
                            Pilih metode pembayaran
                        </option>

                        <option value="cash">
                            Cash
                        </option>

                        <option value="transfer">
                            Transfer
                        </option>

                        <option value="qris">
                            QRIS
                        </option>

                    </select>

                </div>


                <!-- KEMBALIAN -->
                <div class="summary-box mb-3">

                    <div class="d-flex justify-content-between">

                        <span>
                            Kembalian
                        </span>

                        <strong id="change">
                            Rp 0
                        </strong>

                    </div>


                    <div class="text-center mt-2">

                        <strong id="paymentStatus"></strong>

                    </div>

                </div>


                <!-- AKSI -->
                <div class="row">

                    <div class="col-4">

                        <button
                            type="button"
                            id="btnTahan"
                            class="btn btn-warning btn-block"
                        >
                            Tahan
                        </button>

                    </div>


                    <div class="col-4">

                        <button
                            type="button"
                            id="btnBatal"
                            class="btn btn-danger btn-block"
                        >
                            Batal
                        </button>

                    </div>


                    <div class="col-4">

                        <button
                            type="button"
                            id="btnBayar"
                            class="btn btn-success btn-block"
                        >
                            BAYAR & CETAK
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- ================= STRUK ================= -->

<div id="struk">

    <h3>
        PERPUSTAKAAN
    </h3>

    <p class="judul-struk">
        Struk Transaksi Penjualan
    </p>

    <hr>

    <p>
        No. Transaksi:
        <span id="strukNoTransaksi"></span>
    </p>

    <p>
        Kasir:
        Admin
    </p>

    <p>
        Tanggal:
        <span id="strukTanggal"></span>
    </p>

    <hr>

    <div id="strukItems"></div>

    <hr>

    <p>
        Subtotal:
        <strong id="strukSubtotal"></strong>
    </p>

    <p>
        Diskon:
        <strong id="strukDiscount"></strong>
    </p>

    <p>
        Pajak:
        <strong id="strukTax"></strong>
    </p>

    <p>
        Biaya Lain:
        <strong id="strukOtherFee"></strong>
    </p>

    <p class="total-struk">
        Grand Total:
        <strong id="strukTotal"></strong>
    </p>

    <p>
        Pembayaran:
        <strong id="strukPayment"></strong>
    </p>

    <p>
        Kembalian:
        <strong id="strukChange"></strong>
    </p>

    <hr>

    <p class="judul-struk">
        Terima kasih
    </p>

</div>


<!-- ================= JAVASCRIPT ================= -->

<script>

    /* ================= TANGGAL & NOMOR TRANSAKSI ================= */

    document.getElementById('tanggal').innerText =
        new Date().toLocaleDateString('id-ID');


    let nomorTransaksi =
        'TRX-' + Date.now();


    document.getElementById('noTransaksi').innerText =
        nomorTransaksi;



    /* ================= CART ================= */

    let cart = [];

    let transaksiDitahan = [];



    /* ================= TAMBAH PRODUK ================= */

    document.querySelectorAll('.product-item').forEach(function(product) {

        product.addEventListener('click', function() {

            let id = this.dataset.id;

            let name = this.dataset.name;

            let sku = this.dataset.sku;

            let price = parseInt(this.dataset.price);


            let existingProduct =
                cart.find(item => item.id == id);


            if (existingProduct) {

                existingProduct.qty++;

            } else {

                cart.push({

                    id: id,

                    name: name,

                    sku: sku,

                    price: price,

                    qty: 1

                });

            }


            tampilkanCart();

        });

    });



    /* ================= TAMPILKAN CART ================= */

    function tampilkanCart() {

        let cartBody =
            document.getElementById('cartBody');


        cartBody.innerHTML = '';


        cart.forEach(function(item, index) {

            let total =
                item.price * item.qty;


            cartBody.innerHTML += `

                <tr>

                    <td>
                        ${item.name}
                        <br>
                        <small>${item.sku}</small>
                    </td>

                    <td>
                        Rp ${item.price.toLocaleString('id-ID')}
                    </td>

                    <td>

                        <div class="d-flex align-items-center">

                            <button
                                type="button"
                                class="btn btn-sm btn-secondary"
                                onclick="kurangiQty(${index})"
                            >
                                −
                            </button>

                            <span class="mx-2">
                                ${item.qty}
                            </span>

                            <button
                                type="button"
                                class="btn btn-sm btn-primary"
                                onclick="tambahQty(${index})"
                            >
                                +
                            </button>

                        </div>

                    </td>

                    <td>
                        Rp ${total.toLocaleString('id-ID')}
                    </td>

                    <td>

                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            onclick="hapusItem(${index})"
                        >
                            <i class="fas fa-trash"></i>
                        </button>

                    </td>

                </tr>

            `;

        });


        hitungTotal();

    }



    /* ================= TAMBAH QTY ================= */

    function tambahQty(index) {

        cart[index].qty++;

        tampilkanCart();

    }



    /* ================= KURANGI QTY ================= */

    function kurangiQty(index) {

        if (cart[index].qty > 1) {

            cart[index].qty--;

        } else {

            cart.splice(index, 1);

        }


        tampilkanCart();

    }



    /* ================= HAPUS ITEM ================= */

    function hapusItem(index) {

        cart.splice(index, 1);

        tampilkanCart();

    }



    /* ================= HITUNG TOTAL ================= */

    function hitungTotal() {

        let itemCount = 0;

        let subtotal = 0;


        cart.forEach(function(item) {

            itemCount += item.qty;

            subtotal +=
                item.price * item.qty;

        });


        let discount =
            parseInt(
                document.getElementById('discountInput').value
            ) || 0;


        let tax =
            parseInt(
                document.getElementById('taxInput').value
            ) || 0;


        let otherFee =
            parseInt(
                document.getElementById('otherFeeInput').value
            ) || 0;


        let grandTotal =
            subtotal - discount + tax + otherFee;


        if (grandTotal < 0) {

            grandTotal = 0;

        }


        document.getElementById('itemCount').innerText =
            itemCount;


        document.getElementById('subtotal').innerText =
            'Rp ' +
            subtotal.toLocaleString('id-ID');


        document.getElementById('grandTotal').innerText =
            'Rp ' +
            grandTotal.toLocaleString('id-ID');

    }



    /* ================= UPDATE DISKON, PAJAK, BIAYA ================= */

    document
        .getElementById('discountInput')
        .addEventListener('input', hitungTotal);


    document
        .getElementById('taxInput')
        .addEventListener('input', hitungTotal);


    document
        .getElementById('otherFeeInput')
        .addEventListener('input', hitungTotal);



    /* ================= PEMBAYARAN ================= */

    document
        .getElementById('payment')
        .addEventListener('input', function() {

            let payment =
                parseInt(this.value) || 0;


            let grandTotalText =
                document.getElementById('grandTotal').innerText;


            let grandTotal =
                parseInt(
                    grandTotalText.replace(/\D/g, '')
                ) || 0;


            let change =
                payment - grandTotal;


            if (change < 0) {

                document.getElementById('change').innerText =
                    'Kurang Rp ' +
                    Math.abs(change).toLocaleString('id-ID');


                document.getElementById('paymentStatus').innerText =
                    'Pembayaran Belum Cukup';

            } else {

                document.getElementById('change').innerText =
                    'Rp ' +
                    change.toLocaleString('id-ID');


                document.getElementById('paymentStatus').innerText =
                    'Pembayaran Cukup';

            }

        });



    /* ================= BAYAR & CETAK ================= */

    document
    .getElementById('btnBayar')
    .addEventListener('click', async function() {

        if (cart.length === 0) {
            alert('Keranjang masih kosong.');
            return;
        }

        let paymentMethod = document.getElementById('paymentMethod').value;

        if (paymentMethod === '') {
            alert('Silakan pilih metode pembayaran.');
            return;
        }

        let payment = parseInt(document.getElementById('payment').value) || 0;

        let grandTotalText = document.getElementById('grandTotal').innerText;
        let grandTotal = parseInt(grandTotalText.replace(/\D/g, '')) || 0;

        if (payment < grandTotal) {
            alert('Pembayaran masih kurang.');
            return;
        }

        this.disabled = true;

        try {
            const response = await fetch("{{ route('orders.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    cart: cart.map(item => ({
                        id: item.id,
                        qty: item.qty
                    })),
                    customer: document.getElementById('customer').value,
                    discount: document.getElementById('discountInput').value || 0,
                    tax: document.getElementById('taxInput').value || 0,
                    other_fee: document.getElementById('otherFeeInput').value || 0,
                    payment: payment,
                    payment_method: paymentMethod
                })
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Transaksi gagal disimpan.');
            }

            const order = result.order;

            document.getElementById('strukNoTransaksi').innerText =
                order.transaction_number;

            document.getElementById('strukTanggal').innerText =
                new Date(order.created_at).toLocaleDateString('id-ID');

            let strukItems = '';

            cart.forEach(function(item) {
                let totalItem = item.price * item.qty;

                strukItems += `
                    <p>
                        ${item.name} x${item.qty}
                        <br>
                        Rp ${totalItem.toLocaleString('id-ID')}
                    </p>
                `;
            });

            document.getElementById('strukItems').innerHTML = strukItems;

            document.getElementById('strukSubtotal').innerText =
                'Rp ' + Number(order.subtotal).toLocaleString('id-ID');

            document.getElementById('strukDiscount').innerText =
                'Rp ' + Number(order.discount).toLocaleString('id-ID');

            document.getElementById('strukTax').innerText =
                'Rp ' + Number(order.tax).toLocaleString('id-ID');

            document.getElementById('strukOtherFee').innerText =
                'Rp ' + Number(order.other_fee).toLocaleString('id-ID');

            document.getElementById('strukTotal').innerText =
                'Rp ' + Number(order.grand_total).toLocaleString('id-ID');

            document.getElementById('strukPayment').innerText =
                'Rp ' + Number(order.payment).toLocaleString('id-ID');

            document.getElementById('strukChange').innerText =
                'Rp ' + Number(order.change).toLocaleString('id-ID');

            alert('Pembayaran berhasil disimpan.');

            window.print();

        } catch (error) {
            alert(error.message);
            console.error('Kesalahan pembayaran:', error);
        } finally {
            this.disabled = false;
        }

    });



    /* ================= BATAL ================= */

    document
        .getElementById('btnBatal')
        .addEventListener('click', function() {


            cart = [];


            tampilkanCart();


            document.getElementById('payment').value = '';

            document.getElementById('paymentMethod').value = '';

            document.getElementById('discountInput').value = 0;

            document.getElementById('taxInput').value = 0;

            document.getElementById('otherFeeInput').value = 0;

            document.getElementById('change').innerText =
                'Rp 0';

            document.getElementById('paymentStatus').innerText =
                '';


        });



    /* ================= TAHAN ================= */

    document
        .getElementById('btnTahan')
        .addEventListener('click', function() {


            if (cart.length === 0) {

                alert('Keranjang masih kosong.');

                return;

            }


            transaksiDitahan.push({

                cart: [...cart],

                customer:
                    document.getElementById('customer').value,

                discount:
                    document.getElementById('discountInput').value,

                tax:
                    document.getElementById('taxInput').value,

                otherFee:
                    document.getElementById('otherFeeInput').value

            });


            cart = [];


            tampilkanCart();


            document.getElementById('payment').value = '';

            document.getElementById('paymentMethod').value = '';

            document.getElementById('change').innerText =
                'Rp 0';

            document.getElementById('paymentStatus').innerText =
                '';


            alert('Transaksi berhasil ditahan.');

        });



    /* ================= SEARCH PRODUK ================= */

    document
        .getElementById('searchProduct')
        .addEventListener('input', function() {


            let keyword =
                this.value.toLowerCase();


            document
                .querySelectorAll('.product-item')
                .forEach(function(product) {


                    let name =
                        product.dataset.name.toLowerCase();


                    let sku =
                        product.dataset.sku.toLowerCase();


                    if (
                        name.includes(keyword) ||
                        sku.includes(keyword)
                    ) {

                        product.style.display =
                            'inline-block';

                    } else {

                        product.style.display =
                            'none';

                    }

                });

        });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userId = "{{ auth()->id() }}"; 

        console.log('Mendengarkan Private Channel: user.' + userId);

        window.Echo.private('user.' + userId)
            .listen('.OrderPlaced', (e) => {
                console.log('NOTIFIKASI MASUK:', e);
                alert('Transaksi Baru Berhasil: ' + e.order.transaction_number);
            });
    });
</script>

</body>
</html>