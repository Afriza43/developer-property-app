<x-layout-rab title="Daftar Kategori Pekerjaan">
    <x-requirement pageName="Daftar Kategori Pekerjaan">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2 d-flex">
                        <div class="button">
                            <div class="buttons">
                                <a href="#" class="btn btn-success">Tambah
                                    Pekerjaan</a>
                            </div>
                        </div>
                    </div>
                    {{-- Search Bar --}}
                    <div class="col-md-10">
                        <form action="{{ route('categories.selectJobCategory', $projectType->type_id) }}"
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
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Kolom kiri: Form memilih kategori yang belum dipilih -->
            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('categories.storeSelectedJobCategory', $projectType->type_id) }}"
                        method="POST">
                        @csrf
                        <div class="card-body bg-primary text-white">
                            Pilih Kategori Pekerjaan
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Nama Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($availableCategories as $category)
                                        <tr>
                                            <td class="text-center">
                                                <input style="transform: scale(1.5)" type="checkbox" name="categories[]"
                                                    value="{{ $category->category_id }}">
                                            </td>
                                            <td>{{ $category->category_name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada kategori tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <a href="{{ route('rab.index', ['type_id' => $projectType->type_id]) }}"
                                    class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kolom kanan: Daftar kategori yang sudah dipilih -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body bg-success text-white">
                        Kategori Pekerjaan yang Sudah Dipilih
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($selectedCategories as $selected)
                                    <tr>
                                        <td>{{ $selected->category_name }}</td>
                                        <td class="text-center">
                                            <form
                                                action="{{ route('categories.destroySelectedJobCategory', [$projectType->type_id, $selected->category_id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada kategori yang dipilih.</td>
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
