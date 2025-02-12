<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pengeluaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .header-left, .header-right {
            width: 48%; /* Memberi ruang untuk dua kolom */
        }
        .header h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .header p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            margin-bottom: 10px;
            font-size: 18px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        .section p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Invoice Pengeluaran</h1>
        <div class="header-left">
            <p>No Faktur: {{ $pengeluaran->No_Faktur }}</p>
            <p>Tanggal: {{ \Carbon\Carbon::parse($pengeluaran->Tanggal_Pengeluaran)->format('d-m-Y') }}</p>
            <p>Nama Penerima: {{ $pengeluaran->Nama_Penerima }}</p>
            <p>Kasir: {{ $karyawan->Nama_Karyawan }}</p>
        </div>
    </div>

    <!-- Detail Pengeluaran -->
    <div class="section">
        <h3>Detail Pengeluaran</h3>
        <h4>Tujuan: {{ $pengeluaran->Tujuan }}</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Diskon</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0; // Inisialisasi grand total
                @endphp
                @foreach($pengeluaran->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->barang->Nama_Barang }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($detail->Harga_Jual, 0, ',', '.') }}</td>
                    <td>{{ $detail->Diskon }}</td>
                    <td>Rp {{ number_format($detail->Total, 0, ',', '.') }}</td>
                </tr>
                @php
                    $grandTotal += $detail->Total; // Menambahkan total ke grand total
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="5" style="text-align: right;">Grand Total:</td>
                    <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>