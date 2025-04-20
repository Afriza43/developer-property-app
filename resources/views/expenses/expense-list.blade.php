<x-layout-1 title="Laporan Pengeluaran Pembangunan">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan Pengeluaran Pembangunan Rumah</h3>
                    <p class="text-subtitle text-muted">{{ $house->name }}</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <h7>User</h7>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row" id="table-bordered">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4 class="card-title">Total Pengeluaran</h4>
                            <h5 class="card-title text-danger">Rp10.000.000</h5>
                        </div>
                        <div class="card-content">
                            <!-- table bordered -->
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 text-center">
                                    <thead>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>Pengeluaran</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Lihat Bukti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $expense)
                                            <tr>
                                                <td class="text-bold-500">{{ $expense->description }}</td>
                                                <td>{{ number_format($expense->total_expense, 0, ',', '.') }}</td>
                                                <td class="text-bold-500">{{ $expense->purchase_date }}</td>
                                                <td><a href="#"><i class="bi bi-eye-fill h5"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout-1>
