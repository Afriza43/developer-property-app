<x-layout-rab title="Perhitungan Volume Item">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6">
                <h3>Perhitungan Volume Item</h3>
            </div>
            <div class="col-12 col-md-6 text-end">
                <nav class="breadcrumb-header">
                    <h6>User</h6>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="alert alert-primary m-0">
                            Total Volume: {{ number_format($totalVolume, 2) }} m³
                        </div>
                        <button class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#modalTambahPLT">
                            Hitung Volume (P×L×T)
                        </button>
                        <button class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#modalTambahLT">
                            Hitung Volume (Luas×T)
                        </button>
                        <button class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#modalTambahV">
                            Hitung Volume (Volume)
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Panjang</th>
                                        <th>Lebar</th>
                                        <th>Tinggi</th>
                                        <th>Luas</th>
                                        <th>Volume/Unit</th>
                                        <th>Volume Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($job->volume_items as $item)
                                        <tr>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->amount }}</td>
                                            <td>{{ $item->length == 0 ? '-' : $item->length }}</td>
                                            <td>{{ $item->width == 0 ? '-' : $item->width }}</td>
                                            <td>{{ $item->height == 0 ? '-' : $item->height }}</td>
                                            <td>{{ $item->wide == 0 ? '-' : $item->wide }}</td>
                                            <td>{{ number_format($item->volume_per_unit, 2) }}</td>
                                            <td>{{ number_format($item->volume_per_unit * $item->amount, 2) }}</td>
                                            <td>
                                                <button class="btn btn-warning dropdown-toggle btn-sm" type="button"
                                                    id="dropdownEdit{{ $item->volume_items_id }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="dropdownEdit{{ $item->volume_items_id }}">
                                                    <li><a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#modalEditPLT{{ $item->volume_items_id }}">Edit
                                                            P×L×T</a></li>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#modalEditLuasT{{ $item->volume_items_id }}">Edit
                                                            Luas×T</a></li>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal"
                                                            data-bs-target="#modalEditVolume{{ $item->volume_items_id }}">Edit
                                                            Volume</a></li>
                                                    <li>
                                                        <form method="POST"
                                                            action="{{ route('volume.destroy', ['sub_job_id' => $job->sub_job_id, 'volume' => $item->volume_items_id]) }}"
                                                            onsubmit="return confirm('Hapus data volume ini?')"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn dropdown-item text-danger">
                                                                Hapus Volume
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>


                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modalEditPLT{{ $item->volume_items_id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5>Edit Volume (P×L×T)</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST"
                                                        action="{{ route('volume.update', ['sub_job_id' => $job->sub_job_id, 'volume' => $item->volume_items_id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body row g-3">
                                                            <div class="col-md-8">
                                                                <label>Keterangan</label>
                                                                <input type="text" name="description"
                                                                    value="{{ $item->description }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Jumlah</label>
                                                                <input type="number" name="amount"
                                                                    value="{{ $item->amount }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Panjang (m)</label>
                                                                <input type="number" step="any" name="length"
                                                                    value="{{ $item->length }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Lebar (m)</label>
                                                                <input type="number" step="any" name="width"
                                                                    value="{{ $item->width }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Tinggi (m)</label>
                                                                <input type="number" step="any" name="height"
                                                                    value="{{ $item->height }}" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-success"
                                                                type="submit">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalEditLuasT{{ $item->volume_items_id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5>Edit Volume (Luas×T)</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST"
                                                        action="{{ route('volume.update', ['sub_job_id' => $job->sub_job_id, 'volume' => $item->volume_items_id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body row g-3">
                                                            <div class="col-md-8">
                                                                <label>Keterangan</label>
                                                                <input type="text" name="description"
                                                                    value="{{ $item->description }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Jumlah</label>
                                                                <input type="number" name="amount"
                                                                    value="{{ $item->amount }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Luas (m²)</label>
                                                                <input type="number" step="any" name="wide"
                                                                    value="{{ $item->wide }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Tinggi (m)</label>
                                                                <input type="number" step="any" name="height"
                                                                    value="{{ $item->height }}" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-success"
                                                                type="submit">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalEditVolume{{ $item->volume_items_id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5>Edit Volume Langsung</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST"
                                                        action="{{ route('volume.update', ['sub_job_id' => $job->sub_job_id, 'volume' => $item->volume_items_id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body row g-3">
                                                            <div class="col-md-8">
                                                                <label>Keterangan</label>
                                                                <input type="text" name="description"
                                                                    value="{{ $item->description }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>Jumlah</label>
                                                                <input type="number" name="amount"
                                                                    value="{{ $item->amount }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label>Volume (m³)</label>
                                                                <input type="number" step="any"
                                                                    name="volume_per_unit"
                                                                    value="{{ $item->volume_per_unit }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-success"
                                                                type="submit">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center my-3">
                            <a href="{{ route('rab.index', ['type_id' => $job->job_type->type_id]) }}"
                                class="btn btn-success">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal: Hitung Volume (P×L×T) -->
    <div class="modal fade" id="modalTambahPLT" tabindex="-1" aria-labelledby="modalTambahPLTLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Lebar modal diperbesar -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPLTLabel">Hitung Volume (P × L × T)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('volume.store', ['sub_job_id' => $job->sub_job_id]) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="description" class="form-label">Keterangan</label>
                                <input type="text" name="description" class="form-control"
                                    placeholder="Keterangan..">
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Jumlah</label>
                                <input type="number" step="any" name="amount" class="form-control"
                                    placeholder="0.0" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="length" class="form-label">Panjang (m)</label>
                                <input type="number" step="any" name="length" class="form-control"
                                    placeholder="0.0">
                            </div>
                            <div class="col-md-6">
                                <label for="width" class="form-label">Lebar (m)</label>
                                <input type="number" step="any" name="width" class="form-control"
                                    placeholder="0.0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="height" class="form-label">Tinggi (m)</label>
                                <input type="number" step="any" name="height" class="form-control"
                                    placeholder="0.0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Hitung</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal: Hitung Volume (Luas × T) -->
    <div class="modal fade" id="modalTambahLT" tabindex="-1" aria-labelledby="modalTambahLTLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLTLabel">Hitung Volume (Luas × T)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('volume.store', ['sub_job_id' => $job->sub_job_id]) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="description" class="form-label">Keterangan</label>
                                <input type="text" name="description" class="form-control"
                                    placeholder="Keterangan..">
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Jumlah</label>
                                <input type="number" step="any" name="amount" class="form-control"
                                    placeholder="0.0" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="wide" class="form-label">Luas (m²)</label>
                                <input type="number" step="any" name="wide" class="form-control"
                                    placeholder="0.0">
                            </div>
                            <div class="col-md-6">
                                <label for="height2" class="form-label">Tinggi (m)</label>
                                <input type="number" step="any" name="height" class="form-control"
                                    placeholder="0.0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Hitung</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal: Input Volume Langsung -->
    <div class="modal fade" id="modalTambahV" tabindex="-1" aria-labelledby="modalTambahVLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahVLabel">Input Volume Langsung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('volume.store', ['sub_job_id' => $job->sub_job_id]) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="description" class="form-label">Keterangan</label>
                                <input type="text" name="description" class="form-control"
                                    placeholder="Keterangan..">
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Jumlah</label>
                                <input type="number" step="any" name="amount" class="form-control"
                                    placeholder="0.0" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="volume" class="form-label">Volume (m³)</label>
                                <input type="number" step="any" name="volume_per_unit" class="form-control"
                                    placeholder="0.0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-layout-rab>
