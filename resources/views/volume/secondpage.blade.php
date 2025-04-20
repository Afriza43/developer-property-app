<x-layout-rab title="Perhitungan Volume Item">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Perhitungan Volume Item</h3>
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
                        <div class="card-header d-flex flex-wrap gap-2">
                            <div class="alert alert-primary">
                                Total Volume: {{ number_format($totalVolume, 2) }} m³
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">

                                {{-- Form Inline Tambah Rincian --}}
                                <form method="POST" action="{{ route('volume.store', $job->job_id) }}">
                                    @csrf
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="8">Penambahan Rincian</th>
                                            </tr>
                                            <tr>
                                                <th>Keterangan</th>
                                                <th>Jumlah Item</th>
                                                <th>Panjang (m)</th>
                                                <th>Lebar (m)</th>
                                                <th>Tinggi (m)</th>
                                                <th>Luas (m²)</th>
                                                <th>Volume (m³)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="description" class="form-control"
                                                        required></td>
                                                <td><input type="number" name="amount" class="form-control" required>
                                                </td>
                                                <td><input type="number" step="0.01" id="length" name="length"
                                                        class="form-control"></td>
                                                <td><input type="number" step="0.01" id="width" name="width"
                                                        class="form-control"></td>
                                                <td><input type="number" step="0.01" id="height" name="height"
                                                        class="form-control"></td>
                                                <td><input type="number" step="0.01" id="wide" name="wide"
                                                        class="form-control"></td>
                                                <td><input type="text" id="volume" class="form-control" readonly>
                                                </td>
                                                <td>
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success">Tambah</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>

                                {{-- Daftar Volume Items --}}
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>Panjang</th>
                                            <th>Lebar</th>
                                            <th>Tinggi</th>
                                            <th>Luas</th>
                                            <th>Volume/Unit</th>
                                            <th>Volume Total</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($job->volume_items as $item)
                                            <tr id="row-{{ $item->volume_items_id }}">
                                                <form
                                                    action="{{ route('volume.update', ['job' => $job->job_id, 'volume' => $item->volume_items_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <td>{{ $item->description }}</td>

                                                    {{-- Panjang --}}
                                                    <td>
                                                        <span class="text-value">{{ $item->length }}</span>
                                                        <input type="number" step="0.01" name="length"
                                                            value="{{ $item->length }}"
                                                            class="form-control form-input d-none length-input">
                                                    </td>

                                                    {{-- Lebar --}}
                                                    <td>
                                                        <span class="text-value">{{ $item->width }}</span>
                                                        <input type="number" step="0.01" name="width"
                                                            value="{{ $item->width }}"
                                                            class="form-control form-input d-none width-input">
                                                    </td>

                                                    {{-- Tinggi --}}
                                                    <td>
                                                        <span class="text-value">{{ $item->height }}</span>
                                                        <input type="number" step="0.01" name="height"
                                                            value="{{ $item->height }}"
                                                            class="form-control form-input d-none height-input">
                                                    </td>

                                                    {{-- Luas --}}
                                                    <td>
                                                        <span class="text-value">{{ $item->wide }}</span>
                                                        <input type="number" step="0.01" name="wide"
                                                            value="{{ $item->wide }}"
                                                            class="form-control form-input d-none wide-input">
                                                    </td>

                                                    {{-- Volume/Unit --}}
                                                    <td>
                                                        <span
                                                            class="text-value">{{ number_format($item->volume_per_unit, 2) }}</span>
                                                        <input type="number" step="0.01" name="volume_per_unit"
                                                            value="{{ $item->volume_per_unit }}"
                                                            class="form-control form-input d-none volume-input"
                                                            readonly>
                                                    </td>

                                                    {{-- Volume Total --}}
                                                    <td>{{ number_format($item->volume_per_unit * $item->amount, 2) }}
                                                    </td>

                                                    {{-- Aksi --}}
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning btn-edit">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success btn-selesai d-none">
                                                            <i class="bi bi-check2"></i>
                                                        </button>
                                                    </td>
                                                </form>
                                                <td>
                                                    {{-- Delete Form --}}
                                                    <form method="POST"
                                                        action="{{ route('volume.destroy', ['job' => $job->job_id, 'volume' => $item->volume_items_id]) }}"
                                                        onsubmit="return confirm('Hapus data volume ini?')"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div> {{-- table-responsive --}}
                            <div class="text-center my-3">
                                <a href="{{ route('rab.index', ['house_id' => $job->job_category->house->house_id]) }}"
                                    class="btn btn-success">Selesai</a>
                            </div>
                        </div> {{-- card-content --}}
                    </div> {{-- card --}}
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.btn-edit').on('click', function() {
                    const row = $(this).closest('tr');

                    // Tampilkan input dan sembunyikan teks
                    row.find('.text-value').addClass('d-none');
                    row.find('.form-input').removeClass('d-none');

                    $(this).addClass('d-none');
                    row.find('.btn-selesai').removeClass('d-none');
                });

                $('.length-input, .width-input, .height-input, .wide-input, .volume-input').on('input', function() {
                    const row = $(this).closest('tr');

                    const length = parseFloat(row.find('.length-input').val()) || 0;
                    const width = parseFloat(row.find('.width-input').val()) || 0;
                    const height = parseFloat(row.find('.height-input').val()) || 0;
                    const wide = parseFloat(row.find('.wide-input').val()) || 0;
                    const volumeField = row.find('.volume-input');

                    // Reset
                    row.find('.length-input, .width-input, .height-input, .wide-input, .volume-input').prop(
                        'readonly', false).prop('disabled', false);

                    // CASE 1: panjang, lebar, dan tinggi diisi
                    if (length > 0 && width > 0 && height > 0) {
                        const volume = length * width * height;
                        const luas = length * width;
                        row.find('.wide-input').val(luas.toFixed(2)).prop('disabled', true);
                        volumeField.val(volume.toFixed(2));
                    }

                    // CASE 2: luas dan tinggi diisi
                    else if (wide > 0 && height > 0) {
                        const volume = wide * height;
                        row.find('.length-input, .width-input').val(0).prop('disabled', true);
                        volumeField.val(volume.toFixed(2));
                    }

                    // CASE 3: volume langsung diisi
                    else if (volumeField.val() > 0) {
                        row.find('.length-input, .width-input, .height-input, .wide-input').val('').prop(
                            'disabled', true);
                        volumeField.prop('readonly', false);
                    } else {
                        volumeField.val('');
                    }
                });
            });
        </script>
    @endpush
    <script>
        $(document).ready(function() {
            // Fungsi hitung volume otomatis untuk form tambah
            $('input[name="length"], input[name="width"], input[name="height"], input[name="wide"]').on('input',
                function() {
                    const length = parseFloat($('input[name="length"]').val()) || 0;
                    const width = parseFloat($('input[name="width"]').val()) || 0;
                    const height = parseFloat($('input[name="height"]').val()) || 0;
                    const wide = parseFloat($('input[name="wide"]').val()) || 0;
                    const volumeField = $('#volume');

                    if (length > 0 && width > 0 && height > 0) {
                        const volume = length * width * height;
                        $('input[name="wide"]').val((length * width).toFixed(2));
                        volumeField.val(volume.toFixed(2));
                    } else if (wide > 0 && height > 0) {
                        const volume = wide * height;
                        volumeField.val(volume.toFixed(2));
                    } else {
                        volumeField.val('');
                    }
                });
        });
    </script>

</x-layout-rab>
