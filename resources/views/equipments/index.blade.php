<x-layout-rab title="Daftar Alat">
    <x-requirement pageName="Daftar Alat">
        <div class="card-header">
            <div class="button">
                <div class="buttons">
                    <button type="button" class="btn-success btn p-2" data-bs-toggle="modal"
                        data-bs-target="#addEquipment">
                        Tambah Alat
                    </button>
                    <a href="{{ route('rab.index', ['house_id' => request()->house_id]) }}"><button type="button"
                            class="btn-danger btn p-2">
                            Kembali
                        </button>
                    </a>
                </div>

                <!-- Modal Tambah Alat -->
                <div class="modal fade" id="addEquipment" tabindex="-1" aria-labelledby="addEquipmentLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('equipments.store') }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="addEquipmentLabel">Tambah Alat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="equipment_name" class="form-label">Nama Alat</label>
                                        <input type="text" name="equipment_name" class="form-control" maxlength="20"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <input type="text" name="description" class="form-control" maxlength="50"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="equipment_unit" class="form-label">Satuan</label>
                                        <input type="text" name="equipment_unit" class="form-control" maxlength="5"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="equipment_cost" class="form-label">Biaya</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control" id="uang-format" required
                                                placeholder="0">
                                            <input type="hidden" name="equipment_cost" id="uang-asli">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center">
                        <thead>
                            <tr>
                                <th>Nama Alat</th>
                                <th>Deskripsi</th>
                                <th>Satuan</th>
                                <th>Biaya</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipments as $equipment)
                                <tr>
                                    <td>{{ $equipment->equipment_name }}</td>
                                    <td>{{ $equipment->description }}</td>
                                    <td>{{ $equipment->equipment_unit }}</td>
                                    <td>Rp {{ number_format($equipment->equipment_cost, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editEquipmentModal{{ $equipment->equipment_id }}">Edit</button>
                                        <form action="{{ route('equipments.destroy', $equipment->equipment_id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </td>

                                    <!-- Modal Edit Alat -->
                                    <div class="modal fade" id="editEquipmentModal{{ $equipment->equipment_id }}"
                                        tabindex="-1"
                                        aria-labelledby="editEquipmentLabel{{ $equipment->equipment_id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning text-white">
                                                    <h5 class="modal-title"
                                                        id="editEquipmentLabel{{ $equipment->equipment_id }}">Edit Alat
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('equipments.update', $equipment->equipment_id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Alat</label>
                                                            <input type="text" name="equipment_name"
                                                                value="{{ $equipment->equipment_name }}"
                                                                class="form-control" maxlength="20" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Deskripsi</label>
                                                            <input type="text" name="description"
                                                                value="{{ $equipment->description }}"
                                                                class="form-control" maxlength="50" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Satuan</label>
                                                            <input type="text" name="equipment_unit"
                                                                value="{{ $equipment->equipment_unit }}"
                                                                class="form-control" maxlength="5" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Biaya</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="text" class="form-control"
                                                                    id="uang-format{{ $equipment->equipment_id }}"
                                                                    value="{{ number_format($equipment->equipment_cost, 0, ',', '.') }}">
                                                                <input type="hidden" name="equipment_cost"
                                                                    id="uang-asli{{ $equipment->equipment_id }}"
                                                                    value="{{ $equipment->equipment_cost }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                    <script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>
                                                    <script src="{{ asset('dist/assets/extensions/jquery/jquery.mask.min.js') }}"></script>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#uang-format{{ $equipment->equipment_id }}').mask('000.000.000', {
                                                                reverse: true
                                                            });

                                                            $('form').on('submit', function() {
                                                                let uangFormatted = $('#uang-format{{ $equipment->equipment_id }}').val();
                                                                let uangAsli = uangFormatted.replace(/\./g, '');
                                                                $('#uang-asli{{ $equipment->equipment_id }}').val(uangAsli);
                                                            });
                                                        });
                                                    </script>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </x-requirement>
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
