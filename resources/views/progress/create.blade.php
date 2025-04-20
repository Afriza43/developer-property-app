<x-layout-2 title="Tambah Laporan Progres">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Laporan Progres Pembangunan</h3>
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
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Buat Laporan</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('progress.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Keterangan Laporan</label>
                                <input type="text" class="form-control" name="description" id="description"
                                    placeholder="Keterangan">
                            </div>
                            <div class="form-group">
                                <label for="report_date">Tanggal</label>
                                <input type="date" name="report_date" class="form-control" id="report_date"
                                    placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="progress_photo" class="form-label">Foto Bukti</label>
                                <input class="form-control" type="file" id="progress_photo" name="progress_photo">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" value="{{ $house->house_id }}"
                                    name="house_id" id="house_id">
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout-2>
