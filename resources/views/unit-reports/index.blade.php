<x-layout-report title="Laporan Pengeluaran Pembangunan">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last mb-3">
                    <h3>Laporan Pengeluaran Pembangunan Rumah</h3>
                    <p class="text-subtitle text-muted">Rumah {{ $house->name }}</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <h7>User</h7>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-center">

                            {{-- Dropdown untuk memilih laporan --}}
                            <form method="GET" action="{{ route('houses.show', $house->house_id) }}">
                                <select name="type" class="form-select w-50 mx-auto" onchange="this.form.submit()">
                                    <option value="">-- Pilih Jenis Laporan --</option>
                                    <option value="expenses" {{ request('type') === 'expenses' ? 'selected' : '' }}>
                                        Laporan Pengeluaran</option>
                                    <option value="progress" {{ request('type') === 'progress' ? 'selected' : '' }}>
                                        Laporan Progres</option>
                                </select>
                            </form>
                        </div>

                        <div class="card-body">
                            {{-- Tabel Laporan Pengeluaran --}}
                            @if ($type === 'expenses')
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0 text-center" id="table1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Keterangan</th>
                                                <th class="text-center">Pengeluaran</th>
                                                <th class="text-center">Tanggal Pembelian</th>
                                                <th class="text-center">Lihat Bukti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenseReports as $expense)
                                                <tr>
                                                    <td class="text-bold-500">{{ $expense->description }}</td>
                                                    <td>{{ number_format($expense->total_expense, 0, ',', '.') }}</td>
                                                    <td>{{ $expense->purchase_date }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" type="button"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#previewImage-{{ $expense->expense_id }}">
                                                            <i class="bi bi-eye h5"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                                {{-- Modal Preview Gambar --}}
                                                <div class="modal fade" id="previewImage-{{ $expense->expense_id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="previewImage-{{ $expense->expense_id }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="previewImage-{{ $expense->expense_id }}Label">
                                                                    Bukti Pengeluaran</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset('storage/' . $expense->evidence) }}"
                                                                    class="img-fluid" alt="Pratinjau Gambar">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">OK</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif ($type === 'progress')
                                {{-- Tabel Laporan Progres --}}
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0 text-center" id="table1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Keterangan Progres</th>
                                                <th class="text-center">Minggu ke-</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Lihat Bukti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($progressReports as $progress)
                                                <tr>
                                                <tr>
                                                    <td class="text-bold-500">{{ $progress->description }}</td>
                                                    <td>{{ $progress->period }}</td>
                                                    <td>{{ $progress->report_date }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#galleryModal{{ $progress->progress_reports_id }}">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tr>

                                                {{-- Modal Lihat Bukti Progres --}}
                                                <div class="modal fade"
                                                    id="galleryModal{{ $progress->progress_reports_id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="galleryModal{{ $progress->progress_reports_id }}Title"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="galleryModal{{ $progress->progress_reports_id }}Title">
                                                                    Foto Progres Minggu ke-{{ $progress->period }}</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                @php
                                                                    $filteredPhotos =
                                                                        $photos[$progress->progress_reports_id] ??
                                                                        collect();
                                                                @endphp


                                                                @if ($filteredPhotos->count() > 0)
                                                                    <div id="Gallerycarousel{{ $progress->progress_reports_id }}"
                                                                        class="carousel slide carousel-fade"
                                                                        data-bs-ride="carousel">

                                                                        <!-- Indicators -->
                                                                        <div class="carousel-indicators">
                                                                            @foreach ($filteredPhotos as $index => $photo)
                                                                                <button type="button"
                                                                                    data-bs-target="#Gallerycarousel{{ $progress->progress_reports_id }}"
                                                                                    data-bs-slide-to="{{ $index }}"
                                                                                    class="{{ $index === 0 ? 'active' : '' }}"
                                                                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                                                                    aria-label="Slide {{ $index + 1 }}"></button>
                                                                            @endforeach
                                                                        </div>

                                                                        <!-- Slides -->
                                                                        <div class="carousel-inner">
                                                                            @foreach ($filteredPhotos as $index => $photo)
                                                                                <div
                                                                                    class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                                    <img class="d-block w-100 img-fluid"
                                                                                        style="height: 300px; object-fit: cover; object-position: center;"
                                                                                        src="{{ asset('storage/' . $photo->image) }}"
                                                                                        alt="Photo {{ $index + 1 }}">
                                                                                </div>
                                                                            @endforeach
                                                                        </div>

                                                                        <!-- Controls -->
                                                                        <a class="carousel-control-prev"
                                                                            href="#Gallerycarousel{{ $progress->progress_reports_id }}"
                                                                            role="button" data-bs-slide="prev">
                                                                            <span class="carousel-control-prev-icon"
                                                                                aria-hidden="true"></span>
                                                                        </a>
                                                                        <a class="carousel-control-next"
                                                                            href="#Gallerycarousel{{ $progress->progress_reports_id }}"
                                                                            role="button" data-bs-slide="next">
                                                                            <span class="carousel-control-next-icon"
                                                                                aria-hidden="true"></span>
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    <p class="text-center text-muted">Tidak ada foto
                                                                        untuk
                                                                        ditampilkan.</p>
                                                                @endif

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-dark text-center">
                                    Silahkan pilih jenis laporan terlebih dahulu.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout-report>
