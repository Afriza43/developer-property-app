<x-layout-rab title="Daftar Alat">
    <x-requirement pageName="Daftar Alat - Master">
        <div class="card mt-2">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <h3 class="card-title">Tambah Alat</h3>
                        <a href="{{ route('job-equipments.select', session('redirect_sub_job_id')) }}">
                            <button class="btn btn-secondary">Kembali</button>
                        </a>
                    </div>
                </div>
                <hr>
            </div>
            <div class="card-body">
                <form class="form" method="POST" action="{{ route('equipments.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="form-group">
                                <label for="equipment_name" class="form-label">Nama Alat</label>
                                <input type="text" name="equipment_name" class="form-control" maxlength="25"
                                    required>
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
                                <label for="equipment_unit" class="form-label">Satuan</label>
                                <input type="text" name="equipment_unit" class="form-control" maxlength="5"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Tambah</button>
                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>List Alat Bangunan</h3>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto">
                        <table class="table table-bordered mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>Nama Alat</th>
                                    <th>Deskripsi</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($equipments as $equipment)
                                    <tr>
                                        <td>{{ $equipment->equipment_name }}</td>
                                        <td>{{ $equipment->description }}</td>
                                        <td>{{ $equipment->equipment_unit }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editequipmentModal{{ $equipment->equipment_id }}">Edit</button>
                                            <form action="{{ route('equipments.destroy', $equipment->equipment_id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus equipment ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editequipmentModal{{ $equipment->equipment_id }}"
                                            tabindex="-1"
                                            aria-labelledby="editequipmentLabel{{ $equipment->equipment_id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning text-white">
                                                        <h5 class="modal-title"
                                                            id="editequipmentLabel{{ $equipment->equipment_id }}">Edit
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <form method="POST" id="editequipmentForm"
                                                        action="{{ route('equipments.update', $equipment->equipment_id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="edit_equipment_name" class="form-label">Nama
                                                                    equipment</label>
                                                                <input type="text" name="equipment_name"
                                                                    value="{{ $equipment->equipment_name }}"
                                                                    class="form-control" id="edit_equipment_name"
                                                                    maxlength="25" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_description"
                                                                    class="form-label">Deskripsi</label>
                                                                <input type="text" name="description"
                                                                    value="{{ $equipment->description }}"
                                                                    class="form-control" id="edit_description"
                                                                    maxlength="50" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_equipment_unit"
                                                                    class="form-label">Satuan</label>
                                                                <input type="text" name="equipment_unit"
                                                                    value="{{ $equipment->equipment_unit }}"
                                                                    class="form-control" id="edit_equipment_unit"
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
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    theme: 'auto',
                });
            </script>
        @endif

        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    theme: 'auto'
                });
            </script>
        @endif
    </x-requirement>
</x-layout-rab>
