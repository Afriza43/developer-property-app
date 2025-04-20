<x-layout-rab title="Daftar Pekerja">
    <x-requirement pageName="Daftar Pekerja">
        <div class="card-header d-flex flex-wrap gap-2">
            <div class="button">
                <div class="buttons">
                    <a href="{{ route('employees.create') }}" class="btn btn-success">Tambah Pekerja</a>
                </div>
            </div>
            {{-- Search Bar --}}
            <div class="col-md-10">
                <form action="{{ route('job-employees.select', $job->job_id) }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari pekerja..."
                            aria-label="Cari pekerja..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit" id="button-search-employee">
                            <i class="bi bi-search h5"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-content">
            <div class="table-responsive">
                @if ($employees->isNotEmpty())
                    <form action="{{ route('job-employees.storeSelected', $job->job_id) }}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Pilih</th>
                                    <th scope="col">Nama Pekerja</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td class="text-center align-middle">
                                            <input type="checkbox" name="employees[]"
                                                value="{{ $employee->employee_id }}" style="transform: scale(1.5);">
                                        </td>
                                        <td>{{ $employee->position }}</td>
                                        <td class="text-center">{{ $employee->employee_unit }}</td>
                                        <td class="text-end">Rp
                                            {{ number_format($employee->wage, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center gap-3 my-3">
                            <a href="{{ route('jobs.priceAnalysis', $job->job_id) }}"
                                class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Selesai</button>
                        </div>
                    </form>
                @else
                    <div class="text-center my-3">
                        <p class="text-muted">Pekerja Belum Terisi</p>
                        <a href="{{ route('employees.create') }}" class="btn btn-success">Tambah Pekerja</a>
                    </div>
                @endif
            </div>
        </div>
    </x-requirement>
</x-layout-rab>
