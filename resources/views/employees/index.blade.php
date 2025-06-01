<x-layout-rab title="Daftar Pekerja">
    <x-requirement pageName="Daftar Pekerja - Master">
        <div class="card mt-2">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <h3 class="card-title">Tambah Pekerja</h3>
                        <a href="{{ route('job-employees.select', session('redirect_sub_job_id')) }}">
                            <button class="btn btn-secondary">Kembali</button>
                        </a>
                    </div>
                </div>
                <hr>
            </div>
            <div class="card-body">
                <form class="form" method="POST" action="{{ route('employees.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="form-group">
                                <label for="position" class="form-label">Posisi</label>
                                <input type="text" name="position" class="form-control" maxlength="25" required>
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            <div class="form-group">
                                <label for="unit" class="form-label">Satuan</label>
                                <input type="text" name="unit" class="form-control" maxlength="5" required>
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
                <h3>List Pekerja Bangunan</h3>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto">
                        <table class="table table-bordered mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>Posisi</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->unit }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editemployeeModal{{ $employee->employee_id }}">Edit</button>
                                            <form action="{{ route('employees.destroy', $employee->employee_id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus employee ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editemployeeModal{{ $employee->employee_id }}"
                                            tabindex="-1"
                                            aria-labelledby="editemployeeLabel{{ $employee->employee_id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning text-white">
                                                        <h5 class="modal-title"
                                                            id="editemployeeLabel{{ $employee->employee_id }}">Edit
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <form method="POST" id="editemployeeForm"
                                                        action="{{ route('employees.update', $employee->employee_id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="edit_position" class="form-label">Nama
                                                                    employee</label>
                                                                <input type="text" name="position"
                                                                    value="{{ $employee->position }}"
                                                                    class="form-control" id="edit_position"
                                                                    maxlength="25" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_unit" class="form-label">Satuan</label>
                                                                <input type="text" name="unit"
                                                                    value="{{ $employee->unit }}" class="form-control"
                                                                    id="edit_unit" maxlength="5" required>
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
