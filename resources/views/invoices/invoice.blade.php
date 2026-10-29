
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 30px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #eeeeee;
        }
    </style>
</head>
<body>
    <h2>INVOICE PERPUSTAKAAN</h2>

    <p>Nomor Invoice: INV-001</p>
    <p>Tanggal: {{ date('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Buku</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Contoh Buku</td>
                <td>1</td>
                <td>Rp50.000</td>
            </tr>
        </tbody>
    </table>

    <p><strong>Total: Rp50.000</strong></p>
</body>
</html>
