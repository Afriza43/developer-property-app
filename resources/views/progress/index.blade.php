<x-layout-2 title="Laporan Progres Pembangunan">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan Progres Pembangunan Rumah</h3>
                    <p class="text-subtitle text-muted">{{ $house->name }}</p>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row" id="table-bordered">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header text-start">
                            <a href="{{ route('progress.create', ['house_id' => $house->house_id]) }}">
                                <button class="btn btn-success">
                                    <i class="bi bi-plus-lg"></i> Tambah Laporan
                                </button>
                            </a>
                        </div>
                        <div class="card-body">
                            <!-- table bordered -->
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 text-center" id="table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Keterangan Progres</th>
                                            <th class="text-center">Minggu Ke-</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Lihat Bukti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($progress as $progres)
                                            <tr>
                                                <td class="text-bold-500">{{ $progres->description }}</td>
                                                <td>{{ $progres->period }}</td>
                                                <td>{{ $progres->report_date }}</td>
                                                <td>
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#editProgressModal-{{ $progres->progress_reports_id }}"
                                                        class="btn btn-warning">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#galleryModal{{ $progres->progress_reports_id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <form
                                                        action="{{ route('progress.destroy', $progres->progress_reports_id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Hapus rumah ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            {{-- Modal Lihat Bukti Progres --}}
                                            <div class="modal fade" id="galleryModal{{ $progres->progress_reports_id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="galleryModal{{ $progres->progress_reports_id }}Title"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="galleryModal{{ $progres->progress_reports_id }}Title">
                                                                Foto Progres Minggu ke-{{ $progres->period }}</h5>
                                                            <button type="button" class="close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            @php
                                                                $filteredPhotos =
                                                                    $photos[$progres->progress_reports_id] ?? collect();
                                                            @endphp

                                                            @if ($filteredPhotos->count() > 0)
                                                                <div id="Gallerycarousel{{ $progres->progress_reports_id }}"
                                                                    class="carousel slide carousel-fade"
                                                                    data-bs-ride="carousel">

                                                                    <!-- Indicators -->
                                                                    <div class="carousel-indicators">
                                                                        @foreach ($filteredPhotos as $index => $photo)
                                                                            <button type="button"
                                                                                data-bs-target="#Gallerycarousel{{ $progres->progress_reports_id }}"
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
                                                                        href="#Gallerycarousel{{ $progres->progress_reports_id }}"
                                                                        role="button" data-bs-slide="prev">
                                                                        <span class="carousel-control-prev-icon"
                                                                            aria-hidden="true"></span>
                                                                    </a>
                                                                    <a class="carousel-control-next"
                                                                        href="#Gallerycarousel{{ $progres->progress_reports_id }}"
                                                                        role="button" data-bs-slide="next">
                                                                        <span class="carousel-control-next-icon"
                                                                            aria-hidden="true"></span>
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <p class="text-center text-muted">Tidak ada foto untuk
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

                                            {{-- Modal Edit Progress --}}
                                            <div class="modal fade"
                                                id="editProgressModal-{{ $progres->progress_reports_id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="editProgressModalLabel-{{ $progres->progress_reports_id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form
                                                        action="{{ route('progress.update', $progres->progress_reports_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Laporan Progress</h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="description">Deskripsi</label>
                                                                    <input type="text" name="description"
                                                                        class="form-control"
                                                                        value="{{ $progres->description }}" required>
                                                                </div>
                                                                <div class="form-group mt-2">
                                                                    <label for="period">Minggu ke-</label>
                                                                    <input type="number" name="period"
                                                                        class="form-control"
                                                                        value="{{ $progres->period }}" min="1"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Simpan
                                                                    Perubahan</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-2 mb-3">
                                <a href="{{ route('houses.index', ['project_id' => $house->project->project_id]) }}"
                                    class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout-2>
