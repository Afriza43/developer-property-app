<x-layout-rab title="Daftar Material">
    <x-requirement pageName="Daftar Material - Master">
        <div class="card mt-2">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <h3 class="card-title">Tambah Material</h3>
                        <a href="{{ route('job-materials.select', session('redirect_sub_job_id')) }}">
                            <button class="btn btn-secondary">Kembali</button>
                        </a>
                    </div>
                </div>
                <hr>
            </div>
            <div class="card-body">
                <form class="form" method="POST" action="{{ route('materials.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="form-group">
                                <label for="material_name" class="form-label">Nama Material</label>
                                <input type="text" name="material_name" class="form-control" maxlength="25" required>
                            </div>
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="form-group">
                                <label for="description" class="form-label">Deskripsi</label>
                                <input type="text" name="description" class="form-control" maxlength="50" required>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="form-group">
                                <label for="material_unit" class="form-label">Satuan</label>
                                <input type="text" name="material_unit" class="form-control" maxlength="5" required>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success me-1 mb-1">Tambah</button>
                            <button type="reset" class="btn btn-warning me-1 mb-1">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>List Material Bangunan</h3>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto">
                        <table class="table table-bordered mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>Nama Material</th>
                                    <th>Deskripsi</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $material)
                                    <tr>
                                        <td>{{ $material->material_name }}</td>
                                        <td>{{ $material->description }}</td>
                                        <td>{{ $material->material_unit }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editMaterialModal{{ $material->material_id }}">Edit</button>
                                            <form action="{{ route('materials.destroy', $material->material_id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus material ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editMaterialModal{{ $material->material_id }}"
                                            tabindex="-1"
                                            aria-labelledby="editMaterialLabel{{ $material->material_id }}"
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
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-warning">Simpan
                                                                Perubahan</button>
                                                        </div>
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
            </div>
        </div>
    </x-requirement>
</x-layout-rab>
