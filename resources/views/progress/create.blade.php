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
    <form action="{{ route('progress.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Buat Laporan</h4>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" class="form-control" value="{{ $house->house_id }}" name="house_id"
                                id="house_id">
                            <div class="form-group">
                                <label for="description">Keterangan Laporan</label>
                                <input type="text" class="form-control" name="description" id="description"
                                    placeholder="Keterangan">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="report_date">Tanggal</label>
                                <input type="date" name="report_date" class="form-control" id="report_date"
                                    placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="period">Minggu ke-</label>
                                <input type="number" name="period" class="form-control" id="period"
                                    placeholder="Minggu ke-" min="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="row">
                <div class="col-4 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Upload Foto</h5>
                        </div>
                        <input type="hidden" class="form-control" name="progress_reports_id" id="progress_reports_id">
                        <div class="card-body">
                            <span class="text-muted">Max. 5 Foto</span>
                            <!-- File uploader with multiple files upload -->
                            <input type="file" name="images[]" class="multiple-files-filepond" multiple />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="col-12 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary me-1 mb-1"
                onsubmit="return confirm('Data tersimpan permanen, apakah anda yakin?')">Submit</button>
            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
        </div>
    </form>
</x-layout-2>
