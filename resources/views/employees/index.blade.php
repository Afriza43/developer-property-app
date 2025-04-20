<x-layout-rab title="Daftar Karyawan">
    <x-requirement pageName="Daftar Karyawan">
        <div class="card-header">
            <div class="buttons">
                <!-- Tombol untuk membuka modal tambah karyawan -->
                <button type="button" class="btn-success btn p-2" data-bs-toggle="modal" data-bs-target="#addEmployee">
                    Tambah Karyawan
                </button>
                <a href="{{ route('rab.index', ['house_id' => request()->house_id]) }}">
                    <button type="button" class="btn-danger btn p-2">
                        Kembali
                    </button>
                </a>
            </div>

            <!-- Modal Tambah Karyawan -->
            <div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="addEmployeeLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('employees.store') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="addEmployeeLabel">Tambah Karyawan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Posisi</label>
                                    <input type="text" name="position" class="form-control" maxlength="25" required>
                                </div>
                                <div class="mb-3">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" name="unit" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="wage" class="form-label">Gaji</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" id="uang-format" required
                                            placeholder="0">
                                        <input type="hidden" name="wage" id="uang-asli">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar Karyawan -->
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center">
                        <thead>
                            <tr>
                                <th>Posisi</th>
                                <th>Unit</th>
                                <th>Gaji</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->position }}</td>
                                    <td>{{ $employee->unit }}</td>
                                    <td>Rp {{ number_format($employee->wage, 0, ',', '.') }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editEmployeeModal{{ $employee->employee_id }}">
                                            Edit
                                        </button>

                                        <!-- Form Hapus -->
                                        <form action="{{ route('employees.destroy', $employee->employee_id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pekerja ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </td>

                                    <!-- Modal Edit Karyawan -->
                                    <div class="modal fade" id="editEmployeeModal{{ $employee->employee_id }}"
                                        tabindex="-1" aria-labelledby="editEmployeeLabel{{ $employee->employee_id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST"
                                                action="{{ route('employees.update', $employee->employee_id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning text-white">
                                                        <h5 class="modal-title"
                                                            id="editEmployeeLabel{{ $employee->employee_id }}">Edit
                                                            Karyawan
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="position" class="form-label">Posisi</label>
                                                            <input type="text" name="position" class="form-control"
                                                                value="{{ $employee->position }}" maxlength="25"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="unit" class="form-label">Unit</label>
                                                            <input type="text" name="unit" class="form-control"
                                                                value="{{ $employee->unit }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="wage" class="form-label">Gaji</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rp</span>
                                                                <input type="text" class="form-control"
                                                                    id="uang-format{{ $employee->employee_id }}"
                                                                    value="{{ number_format($employee->wage, 0, ',', '.') }}">
                                                                <input type="hidden" name="wage"
                                                                    id="uang-asli{{ $employee->employee_id }}"
                                                                    value="{{ $employee->wage }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                    <script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>
                                                    <script src="{{ asset('dist/assets/extensions/jquery/jquery.mask.min.js') }}"></script>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#uang-format{{ $employee->employee_id }}').mask('000.000.000', {
                                                                reverse: true
                                                            });

                                                            $('form').on('submit', function() {
                                                                let uangFormatted = $('#uang-format{{ $employee->employee_id }}').val();
                                                                let uangAsli = uangFormatted.replace(/\./g, '');
                                                                $('#uang-asli{{ $employee->employee_id }}').val(uangAsli);
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
