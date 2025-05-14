<x-layout-rab title="Daftar Pekerja">
    <x-requirement pageName="Daftar Pekerja">
        <div class="card mt-2">
            <div class="card-header d-flex flex-wrap gap-2">
                <div class="button">
                    <div class="buttons">
                        <a
                            href="{{ route('employees.index', ['set_redirect' => 1, 'sub_job_id' => $subJob->sub_job_id]) }}">
                            <button class="btn btn-primary">Tambah Pegawai</button>
                        </a>
                    </div>
                </div>
                {{-- Search Bar --}}
                <div class="col-md-10">
                    <form action="{{ route('job-employees.select', $subJob->sub_job_id) }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Cari Pekerja..."
                                aria-label="Cari Pekerja..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit" id="button-search-employee">
                                <i class="bi bi-search h5"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="card-content">
                    <form action="{{ route('job-employees.storeSelected', $subJob->sub_job_id) }}" method="POST">
                        @csrf
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Pilih</th>
                                        <th scope="col">Posisi</th>
                                        <th scope="col">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employees as $employee)
                                        <tr>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" name="employees[]"
                                                    value="{{ $employee->employee_id }}" style="transform: scale(1.5);">
                                            </td>
                                            <td>{{ $employee->position }}</td>
                                            <td class="text-center">{{ $employee->unit }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada pekerja ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center gap-3 my-3">
                            <a href="{{ route('jobs.priceAnalysis', $subJob->sub_job_id) }}"
                                class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Selesai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-requirement>
</x-layout-rab>
