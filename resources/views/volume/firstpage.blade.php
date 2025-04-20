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
                                            <tr class="table-success">
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
                                <table class="table table-bordered mt-4">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Keterangan</th>
                                            <th>Jumlah Item</th>
                                            <th>Panjang</th>
                                            <th>Lebar</th>
                                            <th>Tinggi</th>
                                            <th>Luas</th>
                                            <th>Volume (Per Unit)</th>
                                            <th>Total Volume</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse($volumes as $item)
                                            <tr>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->amount }}</td>
                                                <td>{{ $item->length }}</td>
                                                <td>{{ $item->width }}</td>
                                                <td>{{ $item->height }}</td>
                                                <td>{{ $item->wide }}</td>
                                                <td>{{ number_format($item->volume_per_unit, 2) }}</td>
                                                <td>{{ number_format($item->volume_per_unit * $item->amount, 2) }}</td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('volume.destroy', ['job' => $job->job_id, 'volume' => $item->volume_items_id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="bi bi-trash3-fill"></i></button>
                                                    </form>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Belum ada data volume
                                                </td>
                                            </tr>
                                        @endforelse
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
                function calculateVolume() {
                    let length = parseFloat($('#length').val()) || null;
                    let width = parseFloat($('#width').val()) || null;
                    let height = parseFloat($('#height').val()) || null;
                    let wide = parseFloat($('#wide').val()) || null;
                    let volumeField = $('#volume');

                    // Reset volume field
                    volumeField.prop('readonly', true);

                    // Reset disabled fields
                    $('#length, #width, #height, #wide').prop('disabled', false);

                    if (length && width && height) {
                        let volume = length * width * height;
                        volumeField.val(volume.toFixed(2));
                        $('#wide').prop('disabled', true);
                    } else if (wide && height) {
                        let volume = wide * height;
                        volumeField.val(volume.toFixed(3));
                        $('#length, #width').prop('disabled', true);
                    } else if (volumeField.val()) {
                        $('#length, #width, #height, #wide').val('').prop('disabled', true);
                        volumeField.prop('readonly', false);
                    } else {
                        volumeField.val('');
                    }
                }

                $('#length, #width, #height, #wide, #volume').on('input', calculateVolume);
            });
        </script>
    @endpush
</x-layout-rab>
