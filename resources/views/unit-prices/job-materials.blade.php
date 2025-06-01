<x-layout-rab title="Daftar Material">
    <x-requirement pageName="Daftar Material">
        <div class="card mt-2">
            <div class="card-header d-flex flex-wrap gap-2">
                <div class="button">
                    <div class="buttons">
                        <a href="{{ route('materials.index', ['set_redirect' => 1, 'sub_job_id' => $subJob->sub_job_id]) }}"
                            class="btn btn-success">Tambah Material</a>
                    </div>
                </div>
                {{-- Search Bar --}}
                <div class="col-md-10">
                    <form action="{{ route('job-materials.select', $subJob->sub_job_id) }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Cari Material..."
                                aria-label="Cari Material..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit" id="button-search-material">
                                <i class="bi bi-search h5"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="card-content">
                    <form action="{{ route('job-materials.storeSelected', $subJob->sub_job_id) }}" method="POST">
                        @csrf
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Pilih</th>
                                        <th scope="col">Nama Material</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($materials as $material)
                                        <tr>
                                            <td class="text-center align-middle">
                                                <input type="checkbox" name="materials[]"
                                                    value="{{ $material->material_id }}" style="transform: scale(1.5);">
                                            </td>
                                            <td>{{ $material->material_name }}</td>
                                            <td class="text-center">{{ $material->material_unit }}</td>
                                            <td class="text-center">{{ $material->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada material ditemukan.</td>
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
