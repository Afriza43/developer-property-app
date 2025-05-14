<x-layout-rab title="Daftar Equipment">
    <x-requirement pageName="Daftar Alat">
        <div class="card mt-2">
            <div class="card-header d-flex flex-wrap gap-2">
                <div class="button">
                    <div class="buttons">
                        <a href="{{ route('equipments.index', ['set_redirect' => 1, 'sub_job_id' => $subJob->sub_job_id]) }}"
                            class="btn btn-success">Tambah Alat</a>
                    </div>
                </div>
                {{-- Search Bar --}}
                <div class="col-md-10">
                    <form action="{{ route('job-equipments.select', $subJob->sub_job_id) }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Cari alat..."
                                aria-label="Cari equipment..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit" id="button-search-equipment">
                                <i class="bi bi-search h5"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="card-content">
                    <form action="{{ route('job-equipments.storeSelected', $subJob->sub_job_id) }}" method="POST">
                        @csrf
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Pilih</th>
                                        <th scope="col">Nama equipment</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($equipments as $equipment)
                                        <tr>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" name="equipments[]"
                                                    value="{{ $equipment->equipment_id }}"
                                                    style="transform: scale(1.5);">
                                            </td>
                                            <td>{{ $equipment->equipment_name }}</td>
                                            <td class="text-center">{{ $equipment->equipment_unit }}</td>
                                            <td>{{ $equipment->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada alat ditemukan.</td>
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
