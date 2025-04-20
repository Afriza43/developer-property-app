<x-layout-rab title="Daftar Material">
    <x-requirement pageName="Daftar Material">
        <div class="card-header">
            <div class="button">
                <!-- Tombol untuk membuka modal -->
                <div class="buttons">
                    <button type="button" class="btn-success btn p-2" data-bs-toggle="modal" data-bs-target="#addMaterial">
                        Tambah Material
                    </button>
                    <a href="{{ route('rab.index', ['house_id' => request()->house_id]) }}"><button type="button"
                            class="btn-danger btn p-2">
                            Kembali
                        </button>
                    </a>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addMaterial" tabindex="-1" aria-labelledby="addMaterialLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('materials.store') }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="addMaterialLabel">Tambah Material</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="material_name" class="form-label">Nama Material</label>
                                        <input type="text" name="material_name" class="form-control" maxlength="25"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <input type="text" name="description" class="form-control" maxlength="50"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="material_unit" class="form-label">Satuan</label>
                                        <input type="text" name="material_unit" class="form-control" maxlength="5"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="material_cost" class="form-label">Biaya</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control" id="uang-format" step="0.01"
                                                required placeholder="0">
                                            <input type="hidden" name="material_cost" id="uang-asli">
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
                                <th>Nama Material</th>
                                <th>Deskripsi</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $material->material_name }}</td>
                                    <td>{{ $material->description }}</td>
                                    <td>{{ $material->material_unit }}</td>
                                    <td>Rp {{ number_format($material->material_cost, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editMaterialModal{{ $material->material_id }}">Edit</button>
                                        <form action="{{ route('materials.destroy', $material->material_id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus material ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </td>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editMaterialModal{{ $material->material_id }}"
                                        tabindex="-1" aria-labelledby="editMaterialLabel{{ $material->material_id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning text-white">
                                                    <h5 class="modal-title"
                                                        id="editMaterialLabel{{ $material->material_id }}">Edit
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <form method="POST" id="editMaterialForm"
                                                    action="{{ route('materials.update', $material->material_id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="edit_material_name" class="form-label">Nama
                                                                Material</label>
                                                            <input type="text" name="material_name"
                                                                value="{{ $material->material_name }}"
                                                                class="form-control" id="edit_material_name"
                                                                maxlength="25" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_description"
                                                                class="form-label">Deskripsi</label>
                                                            <input type="text" name="description"
                                                                value="{{ $material->description }}"
                                                                class="form-control" id="edit_description"
                                                                maxlength="50" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_material_unit"
                                                                class="form-label">Satuan</label>
                                                            <input type="text" name="material_unit"
                                                                value="{{ $material->material_unit }}"
                                                                class="form-control" id="edit_material_unit"
                                                                maxlength="5" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_material_cost"
                                                                class="form-label">Biaya</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="text" class="form-control"
                                                                    id="uang-format{{ $material->material_id }}"
                                                                    value="{{ number_format($material->material_cost, 0, ',', '.') }}">
                                                                <input type="hidden" name="material_cost"
                                                                    id="uang-asli{{ $material->material_id }}"
                                                                    value="{{ $material->material_cost }}">
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
                                                            $('#uang-format' + {{ $material->material_id }}).mask('000.000.000', {
                                                                reverse: true
                                                            });

                                                            $('form').on('submit', function() {
                                                                let uangFormatted = $('#uang-format' +
                                                                    {{ $material->material_id }}).val();
                                                                let uangAsli = uangFormatted.replace(/\./g, '');
                                                                $('#uang-asli' + {{ $material->material_id }}).val(uangAsli);
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
