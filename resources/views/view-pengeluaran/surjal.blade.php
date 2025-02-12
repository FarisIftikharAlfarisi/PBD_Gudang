<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pengeluaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header, .footer { text-align: center; }
        .footer { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice Pengeluaran</h1>
    </div>
    <div>
            <p>No Faktur: {{ $pengeluaran->No_Faktur }}</p>
            <p>Tanggal: {{ \Carbon\Carbon::parse($pengeluaran->Tanggal_Pengeluaran)->format('d-m-Y') }}</p>
            <p>Nama Penerima: {{ $pengeluaran->Nama_Penerima }}</p>
            <p>Kasir: {{ $karyawan->Nama_Karyawan }}</p>
    </div>

    <div>
        <h3>Detail Pengeluaran</h3>
        <h4>Tujuan : {{ $pengeluaran->Tujuan }}</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengeluaran->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->barang->Nama_Barang }}</td>
                    <td>{{ $detail->qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="footer">
        <p>Dicetak pada: {{ now() }}</p>
    </div>
</body>
</html>
