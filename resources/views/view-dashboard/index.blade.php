@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Halo Selamat Datang, {{ Auth::guard('karyawan')->user()->Nama_Karyawan }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Dashboard</a></li>
        <li class="breadcrumb-item active">Analisis Penjualan</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<div class="row">
    <!-- Left side columns -->
    <div class="col-lg-12">
        <div class="row">

            <!-- Pie Chart: Dominasi Customer -->
            <div class="col-xxl-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dominasi Customer</h5>
                        <div id="customerPieChart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#customerPieChart"), {
                                    series: [70, 30], // Replace with dynamic data
                                    chart: {
                                        type: 'pie',
                                        height: 350
                                    },
                                    labels: ['Pelanggan Tetap', 'Pelanggan Biasa'],
                                    colors: ['#2eca6a', '#ff771d'],
                                }).render();
                            });
                        </script>
                    </div>
                </div>
            </div><!-- End Pie Chart -->

            <!-- Line Chart: Revenue Penjualan -->
            <div class="col-xxl-8 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Revenue Penjualan</h5>
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start"><h6>Filter</h6></li>
                                <li><a class="dropdown-item" href="#" onclick="updateRevenueChart('daily')">Harian</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateRevenueChart('monthly')">Bulanan</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateRevenueChart('yearly')">Tahunan</a></li>
                            </ul>
                        </div>
                        <div id="revenueLineChart"></div>
                        <script>
                            const revenueData = {
                                daily: [150, 200, 170, 250, 300, 180],
                                monthly: [3000, 4000, 5000, 6000, 7000],
                                yearly: [40000, 50000, 60000, 70000, 80000]
                            };

                            document.addEventListener("DOMContentLoaded", () => {
                                window.revenueChart = new ApexCharts(document.querySelector("#revenueLineChart"), {
                                    series: [{ name: 'Revenue', data: revenueData.daily }],
                                    chart: { type: 'line', height: 350 },
                                    xaxis: { categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] },
                                    stroke: { curve: 'smooth', width: 2 },
                                    colors: ['#4154f1'],
                                });
                                window.revenueChart.render();
                            });

                            function updateRevenueChart(filter) {
                                const categories = filter === 'daily' ? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] :
                                    filter === 'monthly' ? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'] : ['2019', '2020', '2021', '2022'];
                                window.revenueChart.updateOptions({
                                    series: [{ name: 'Revenue', data: revenueData[filter] }],
                                    xaxis: { categories }
                                });
                            }
                        </script>
                    </div>
                </div>
            </div><!-- End Line Chart -->

            <!-- Bar Chart: Barang Terlaris -->
            <div class="col-xxl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Barang Terlaris</h5>
                        <div id="bestSellingBarChart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#bestSellingBarChart"), {
                                    series: [{
                                        name: 'Jumlah Penjualan',
                                        data: [120, 95, 80, 60, 40] // Replace with dynamic data
                                    }],
                                    chart: { type: 'bar', height: 350 },
                                    xaxis: { categories: ['Oli', 'Ban', 'Aki', 'Lampu', 'Sparepart Lain'] },
                                    colors: ['#ff771d'],
                                }).render();
                            });
                        </script>
                    </div>
                </div>
            </div><!-- End Bar Chart -->

        </div>
    </div><!-- End Left side columns -->
</div>


    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Surplus Barang</h5>

              <!-- Default Tabs -->
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Unit Kasir</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Unit Pengeluaran</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Unit Penerimaan</button>
                </li>
              </ul>
              <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No. Dokumen</th>
                                <th>Tanggal</th>
                                <th>Nilai Transaksi</th>
                                <th>Metode Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No. Dokumen</th>
                                <th>Tanggal</th>
                                <th>Nilai Transaksi</th>
                                <th>Penerima</th>
                                <th>Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No. Dokumen</th>
                                <th>Tanggal</th>
                                <th>Nilai Transaksi</th>
                                <th>Barang Diterima</th>
                                <th>Nama Supplier</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
              </div><!-- End Default Tabs -->

            </div>
          </div>
    </div>
  </div>

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
