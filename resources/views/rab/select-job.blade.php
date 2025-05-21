<x-layout-rab title="Daftar Sub Pekerjaan">
    <x-requirement pageName="Daftar Sub {{ $jobType->job_category->category_name }}">
        <div class="card mt-2">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2 d-flex">
                        <div class="button">
                            <div class="buttons">
                                <button class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addJobModal">Tambah Sub Pekerjaan</button>
                            </div>
                        </div>
                    </div>
                    {{-- Search Bar --}}
                    <div class="col-md-9">
                        <form
                            action="{{ route('jobs.selectJob', ['jobtype_id' => $jobType->jobtype_id, 'type_id' => $jobType->type_id]) }}"
                            method="GET">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari kategori pekerjaan..." aria-label="Cari kategori pekerjaan..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit" id="button-search-equipment">
                                    <i class="bi bi-search h5"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('rab.index', ['type_id' => $jobType->type_id]) }}"
                            class="btn btn-secondary">Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Kolom kiri: Pekerjaan yang belum dipilih -->
            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('jobs.storeSelectedJob', $jobType->jobtype_id) }}" method="POST">
                        @csrf
                        <div class="card-body bg-primary text-white">Pilih Pekerjaan</div>
                        <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Nama Pekerjaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($availableJobs as $job)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="jobs[]" value="{{ $job->job_id }}"
                                                    style="transform: scale(1.5)">
                                            </td>
                                            <td>{{ $job->job_name }}</td>
                                            <td class="text-center">
                                                <button style="color: orange" type="button" class="btn p-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editJobModal-{{ $job->job_id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada pekerjaan tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center my-3 gap-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kolom kanan: Pekerjaan yang sudah dipilih -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body bg-success text-white">Pekerjaan Sudah Dipilih</div>
                    <div class="card-body table-responsive" style="max-height: 400px; overflow-y: auto">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>Nama Pekerjaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($selectedJobs as $job)
                                    <tr>
                                        <td>{{ $job->job->job_name }}</td>
                                        <td class="text-center">
                                            <form
                                                action="{{ route('jobs.destroySelectedJob', [$jobType->jobtype_id, $job->job_id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pekerjaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada pekerjaan yang dipilih.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('jobs.addJob', $jobType->jobtype_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addJobModalLabel">Tambah Sub Pekerjaan</h5>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="job_name" class="form-label">Nama Pekerjaan</label>
                                <input type="text" class="form-control" id="job_name" name="job_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="satuan_volume" class="form-label">Satuan Volume</label>
                                <input type="text" class="form-control" id="satuan_volume" name="satuan_volume"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($availableJobs as $job)
            <div class="modal fade" id="editJobModal-{{ $job->job_id }}" tabindex="-1"
                aria-labelledby="editJobModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('jobs.updateJob', $job->job_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editJobModalLabel">Edit Sub
                                    Pekerjaan</h5>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="job_name" class="form-label">Nama
                                        Pekerjaan</label>
                                    <input type="text" class="form-control" id="job_name" name="job_name"
                                        value="{{ $job->job_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="satuan_volume" class="form-label">Satuan
                                        Volume</label>
                                    <input type="text" class="form-control" id="satuan_volume"
                                        name="satuan_volume" value="{{ $job->satuan_volume }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </x-requirement>
</x-layout-rab>
