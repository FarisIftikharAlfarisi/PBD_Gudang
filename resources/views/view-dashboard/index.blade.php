@extends('Partials.dashboard-template-main')
@section('dashboard-content')
<div class="pagetitle">
    <h1>Halo Selamat Datang, {{ Auth::guard('karyawan')->user()->Nama_Karyawan }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Analisis Penjualan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <!-- Pie Chart: Dominasi Metode Pembayaran -->
            <div class="col-xxl-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dominasi Metode Pembayaran</h5>
                        <div id="customerPieChart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#customerPieChart"), {
                                    series: @json($metode_chart_data->pluck('count')),
                                    chart: { type: 'pie', height: 350 },
                                    labels: @json($metode_chart_data->pluck('label')),
                                    colors: ['#2eca6a', '#ff771d', '#ff455f'],
                                }).render();
                            });
                        </script>
                    </div>
                </div>
            </div>

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
                                daily: @json($revenue_daily->pluck('revenue')),
                                monthly: @json($revenue_monthly->pluck('revenue')),
                                yearly: @json($revenue_yearly->pluck('revenue'))
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
                                const categories = filter === 'daily' ? @json($revenue_daily->pluck('date')) :
                                    filter === 'monthly' ? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'] : @json($revenue_yearly->pluck('year'));
                                window.revenueChart.updateOptions({
                                    series: [{ name: 'Revenue', data: revenueData[filter] }],
                                    xaxis: { categories }
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>

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
                                    data: @json($best_selling_items->pluck('total_sold'))
                                }],
                                chart: { type: 'bar', height: 350 },
                                xaxis: { 
                                    categories: @json($best_selling_items->pluck('Nama_Barang'))  // Use Nama_Barang directly
                                },
                                colors: ['#ff771d'],
                            }).render();
                        });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                <th>Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_order as $r)
                            <tr>
                                <td>{{ $r->Nomor_Nota }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('dmY', $r->Tanggal_Pembelian)->isoFormat('dddd, D MMMM YYYY') }}</td>
                                <td>Rp. {{ number_format($r->Total_Pembayaran, 0, ',', '.') }}</td>
                                <td>{{ $r->Metode_Pembayaran }}</td>
                                <td>
                                    <!-- Tombol untuk membuka modal detail -->
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail" 
                                            onclick="loadDetail('{{ $r->id }}')">Detail</button>
                                    <button class="btn btn-sm btn-primary" onclick="window.open('{{ route('cetak-nota', $r->id) }}', '_blank')">Print</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modal Detail -->
            <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetailLabel">Detail Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="detailContent">Memuat detail...</div>
                        </div>
                    </div>
                </div>
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
                        @foreach ($data_pengeluaran as $pengeluaran)
                            <tr>
                                <td>{{ $pengeluaran->No_Faktur }}</td>
                                <td>{{ $pengeluaran->Tanggal_Pengeluaran }}</td>
                                <td>{{ number_format($pengeluaran->Total, 0, ',', '.') }}</td>
                                <td>{{ $pengeluaran->Nama_Penerima }}</td>
                                <td>{{ $pengeluaran->Tujuan }}</td>
                                
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>No. Dokumen</th>
                                <th>Tanggal</th>
                                {{-- <th>Nilai Transaksi</th>
                                <th>Barang Diterima</th> --}}
                                <th>Nama Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_penerimaan as $penerimaan)
                            <tr>
                                <td>{{ $penerimaan->No_Faktur }}</td>
                                <td>{{ $penerimaan->Tanggal_Penerimaan }}</td>
                                <td>{{ $penerimaan->supplier->Nama_Supplier }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- End Default Tabs -->


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
<script>
    function loadDetail(id) {
        const detailContent = document.getElementById('detailContent');
        detailContent.innerHTML = 'Memuat detail...';
    
        fetch(`/transaksi/detail/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = `
                        <p><strong>Nomor Nota:</strong> ${data.detail.Nomor_Nota}</p>
                        <p><strong>Tanggal Transaksi:</strong> ${data.detail.Tanggal_Pembelian}</p>
                        <p><strong>Metode Pembayaran:</strong> ${data.detail.Metode_Pembayaran}</p>
                        <h5>Detail Barang:</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Diskon Per Barang</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>`;
                    data.detail.items.forEach((item, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.nama_barang}</td>
                                <td>${item.jumlah}</td>
                                <td>Rp. ${item.harga}</td>
                                <td>Rp. ${item.diskon}</td>
                                <td>Rp. ${item.subtotal}</td>
                            </tr>`;
                    });
                    html += `</tbody></table>`;
    
                    // Now add the payment details below the table
                    html += `
                        <div>
                            <p><strong>Total Pembayaran:</strong> Rp. ${data.detail.Total_Pembayaran}</p>
                            <p><strong>Cash:</strong> Rp. ${data.detail.Uang_Masuk}</p>
                            <p><strong>Kembalian:</strong> Rp. ${data.detail.Kembalian}</p>
                        </div>`;
    
                    detailContent.innerHTML = html;
                } else {
                    detailContent.innerHTML = 'Gagal memuat detail.';
                }
            })
            .catch(() => {
                detailContent.innerHTML = 'Terjadi kesalahan saat memuat detail.';
            });
    }
    </script>
