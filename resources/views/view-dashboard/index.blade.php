@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Halo Selamat Datang, {{ Auth::user()->Nama_Karyawan }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Dashboard</a></li>
        <li class="breadcrumb-item active">Analisis Penjualan</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
{{-- <div class="row" id="filter">
    <div class="card">
        <div class="card-title"> Filter Grafik</div>
        <div class="col-lg-11 justify-content-evenly">
            <form method="GET" action="{{ route('analisis') }}" class="row mb-4">
                <div class="col-md-4">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" name="tahun" class="form-select">
                        @for ($y = date('Y'); $y >= 2015; $y--)
                            <option value="{{ $y }}" {{ $y == request('tahun', date('Y')) ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select id="bulan" name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == request('bulan') ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="hari" class="form-label">Hari</label>
                    <select id="hari" name="hari" class="form-select">
                        <option value="">Semua Hari</option>
                        @for ($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}" {{ $d == request('hari') ? 'selected' : '' }}>{{ $d }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mt-3 justify-content-end d-md-flex">
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pembelian dari Supplier</h5>
                <div id="penerimaanChart"></div>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const penerimaanData = @json($penerimaanData);
                        const tanggal = penerimaanData.map(item => item.tanggal);
                        const totalHarga = penerimaanData.map(item => parseFloat(item.total_harga));

                        new ApexCharts(document.querySelector("#penerimaanChart"), {
                            series: [{ name: "Total Harga", data: totalHarga }],
                            chart: { type: 'line', height: 350 },
                            xaxis: { categories: tanggal },
                            dataLabels: { enabled: false },
                            stroke: { curve: 'smooth' }
                        }).render();
                    });
                </script>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Penjualan kepada Customer</h5>
                <div id="pengeluaranChart"></div>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const pengeluaranData = @json($pengeluaranData);
                        const tanggal = pengeluaranData.map(item => item.tanggal);
                        const totalKeuntungan = pengeluaranData.map(item => parseFloat(item.total_keuntungan));

                        new ApexCharts(document.querySelector("#pengeluaranChart"), {
                            series: [{ name: "Total Keuntungan", data: totalKeuntungan }],
                            chart: { type: 'line', height: 350 },
                            xaxis: { categories: tanggal },
                            dataLabels: { enabled: false },
                            stroke: { curve: 'smooth' }
                        }).render();
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
            <div class="card-title">Barang Yang Paling Diminati</div>
            <div id="barChartMostWanted"></div>

            <script>
            document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#barChartMostWanted"), {
                series: [{name: "Jumlah Pembelian",data: @json($mostWanted->pluck('total_pembelian'))}],
                chart: {type: 'bar',height: 350},
                plotOptions: {
                    bar: {
                    borderRadius: 4,
                    horizontal: true,
                    }
                },
                dataLabels: {enabled: false},
                xaxis: {categories: @json($mostWanted->pluck('Nama_Barang'))},
                }).render();
            });
            </script>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Barang Yang Kurang Diminati</div>
                <!-- Bar Chart Barang dengan Stok Tertinggi yang Kurang Diminati -->
                <div id="barChartLeastWanted"></div>

                <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#barChartLeastWanted"), {
                    series: [{name: "Stok Barang",data: @json($leastWanted->pluck('Jumlah_Barang_Aktual'))}],
                    chart: {type: 'bar',height: 350},
                    plotOptions: {
                        bar: {borderRadius: 4,horizontal: true,}
                    },
                    dataLabels: {enabled: false},
                    xaxis: {categories: @json($leastWanted->pluck('Nama_Barang'))},
                    }).render();
                });
                </script>
        </div>
    </div>
</div>
</div> --}}
{{-- <div class="row">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Karyawan dengan Pengeluaran dan Penerimaan Terbanyak</h5>
                <div id="columnChart"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        // Data dari server
                        const pengeluaranData = @json($pengeluaranDataByEmp);
                        // const penerimaanData = @json($penerimaanDataByEmp);

                        // Mengambil nama karyawan dan data total
                        const categories = pengeluaranData.map(item => item.Nama_Karyawan);
                        const seriesPengeluaran = pengeluaranData.map(item => item.total_pengeluaran);
                        // const seriesPenerimaan = penerimaanData.map(item => item.total_penerimaan);

                        // Membuat chart
                        new ApexCharts(document.querySelector("#columnChart"), {
                            series: [{
                                name: 'Pengeluaran',
                                data: seriesPengeluaran
                            }],
                            // }, {
                            //     name: 'Penerimaan',
                            //     data: seriesPenerimaan
                            // }],
                            chart: {
                                type: 'bar',
                                height: 350
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '55%',
                                    endingShape: 'rounded'
                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                show: true,
                                width: 2,
                                colors: ['transparent']
                            },
                            xaxis: {
                                categories: categories,
                            },
                            yaxis: {
                                title: {
                                    text: 'Jumlah Transaksi'
                                }
                            },
                            fill: {
                                opacity: 1
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + " transaksi"
                                    }
                                }
                            }
                        }).render();
                    });
                </script>
            </div>
        </div>
    </div>

</div> --}}
@endsection
