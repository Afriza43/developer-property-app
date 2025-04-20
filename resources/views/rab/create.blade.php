<x-layout-rab title="Tambah Kategori Pekerjaan">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>RAB Pembangunan</h3>
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
                <h4 class="card-title">Tambah Kategori Pekerjaan</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('rab.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_name">Jenis Pekerjaan</label>
                                <input type="text" class="form-control" name="category_name" id="category_name"
                                    placeholder="Jenis Pekerjaan">
                            </div>

                            <div class="form-group">
                                <input type="hidden" class="form-control" value="{{ $house->house_id }}"
                                    name="house_id" id="house_id">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" value="" name="category_cost"
                                    id="category_cost">
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
    <script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/jquery/jquery.mask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#uang-format').mask('000.000.000', {
                reverse: true
            });

            $('form').on('submit', function() {
                let uangFormatted = $('#uang-format').val();
                let uangAsli = uangFormatted.replace(/\./g, '');
                $('#uang-asli').val(uangAsli);
            });
        });
    </script>
</x-layout-rab>
