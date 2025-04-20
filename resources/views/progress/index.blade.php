<x-layout-2 title="Laporan Progres Pembangunan">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan Progres Pembangunan Rumah</h3>
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
                            <div class="button">
                                <div class="buttons">
                                    <a href="{{ route('progress.create', ['house_id' => $house->house_id]) }}"
                                        class="btn btn-success">Tambah Data</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <!-- table bordered -->
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 text-center">
                                    <thead>
                                        <tr>
                                            <th>Deskripsi Progres</th>
                                            <th>Tanggal</th>
                                            <th>Bukti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($progress as $progres)
                                            <tr>
                                                <td class="text-bold-500">{{ $progres->description }}</td>
                                                <td class="text-bold-500">{{ $progres->report_date }}</td>
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
</x-layout-2>
