<x-layout-rab title="Daftar Sub Pekerjaan">
    <x-requirement pageName="Daftar Sub {{ $jobCategory->category_name }}">
        <div class="card mt-2">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2 d-flex">
                        <div class="button">
                            <div class="buttons">
                                <a href="#" class="btn btn-success">Tambah Sub
                                    Pekerjaan</a>
                            </div>
                        </div>
                    </div>
                    {{-- Search Bar --}}
                    <div class="col-md-9">
                        <form action="{{ route('jobs.selectJob', $jobCategory->category_id) }}" method="GET">
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
                        <a href="{{ route('rab.index', ['type_id' => $jobCategory->project_types->first()->type_id]) }}"
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
                    <form action="{{ route('jobs.storeSelectedJob', $jobCategory->category_id) }}" method="POST">
                        @csrf
                        <div class="card-body bg-primary text-white">Pilih Pekerjaan</div>
                        <div class="card-body table-responsive" style="max-height: 400px; overflow-y: auto">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Nama Pekerjaan</th>
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
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada pekerjaan tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3 gap-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
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
                                        <td>{{ $job->job_name }}</td>
                                        <td class="text-center">
                                            <form
                                                action="{{ route('jobs.destroySelectedJob', [$jobCategory->category_id, $job->job_id]) }}"
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
    </x-requirement>
</x-layout-rab>
