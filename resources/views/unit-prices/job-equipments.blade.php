<x-layout-rab title="Daftar Alat">
    <x-requirement pageName="Daftar Alat">
        <div class="card-header d-flex flex-wrap gap-2">
            <div class="button">
                <div class="buttons">
                    <a href="{{ route('equipments.create') }}" class="btn btn-success">Tambah
                        Alat</a>
                </div>
            </div>
            {{-- Search Bar --}}
            <div class="col-md-10">
                <form action="{{ route('job-equipments.select', $job->job_id) }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari alat..."
                            aria-label="Cari alat..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit" id="button-search-equipment">
                            <i class="bi bi-search h5"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-content">
            <div class="table-responsive">
                <form action="{{ route('job-equipments.storeSelected', $job->job_id) }}" method="POST">
                    @csrf
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">Pilih</th>
                                <th scope="col">Nama Alat</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($equipments as $equipment)
                                <tr>
                                    <td class="text-center align-middle">
                                        <input type="checkbox" name="equipments[]"
                                            value="{{ $equipment->equipment_id }}" style="transform: scale(1.5);">
                                    </td>
                                    <td>{{ $equipment->equipment_name }}</td>
                                    <td>{{ $equipment->description }}</td>
                                    <td class="text-center">{{ $equipment->equipment_unit }}</td>
                                    <td class="text-end">Rp {{ number_format($equipment->equipment_cost, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada alat ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center gap-3 my-3">
                        <a href="{{ route('jobs.priceAnalysis', $job->job_id) }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Selesai</button>
                    </div>
                </form>
            </div>
        </div>
    </x-requirement>
</x-layout-rab>
