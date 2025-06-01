<x-layout-rab title="Daftar Pekerjaan">
    <x-requirement pageName="Daftar Pekerjaan">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2 d-flex">
                        <div class="button">
                            <div class="buttons">
                                <button class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addJobCategoryModal">Tambah Pekerjaan</button>
                            </div>
                        </div>
                    </div>
                    {{-- Search Bar --}}
                    <div class="col-md-9">
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
                    <div class="col-md-1">
                        <a href="{{ route('rab.index', ['type_id' => $projectType->type_id]) }}"
                            class="btn btn-secondary">Kembali</a>
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
                        <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th class="text-center">
                                            <input type="checkbox" id="select-all" style="transform: scale(1.5)">
                                        </th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
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
                                            <td class="text-center">
                                                <button style="color: orange" type="button" class="btn p-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCategoryModal-{{ $category->category_id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada kategori tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center gap-3 my-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                                        <td>{{ $selected->job_category->category_name }}</td>
                                        <td class="text-center">
                                            <form
                                                action="{{ route('categories.destroySelectedJobCategory', [$projectType->type_id, $selected->job_category->category_id]) }}"
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

        <div class="modal fade" id="addJobCategoryModal" tabindex="-1" aria-labelledby="addJobCategoryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('categories.addJobCategory', $projectType->type_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addJobCategoryModalLabel">Tambah Pekerjaan</h5>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Nama Pekerjaan</label>
                                <input type="text" class="form-control" id="category_name"
                                    @error('category_name')
                                    is-invalid
                                @enderror
                                    name="category_name" placeholder="Nama Pekerjaan.." required>
                                <span class="text-danger">
                                    @error('category_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="classification" class="form-label">Kategori</label>
                                <select class="form-control" id="classification" name="classification" required>
                                    <option>Pilih Kategori..</option>
                                    <option value="Konstruksi">
                                        Konstruksi</option>
                                    <option value="Sarana">Sarana
                                    </option>
                                    <option value="Prasarana">Prasarana
                                    </option>
                                </select>
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

        @foreach ($availableCategories as $category)
            <div class="modal fade" id="editCategoryModal-{{ $category->category_id }}" tabindex="-1"
                aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('categories.updateJobCategory', $category->category_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCategoryModalLabel">Edit
                                    Pekerjaan</h5>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Nama
                                        Pekerjaan</label>
                                    <input type="text" class="form-control" id="category_name"
                                        name="category_name" value="{{ $category->category_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="classification" class="form-label">Kategori</label>
                                    <select class="form-control" id="classification" name="classification" required>
                                        <option value="Konstruksi"
                                            {{ $category->classification == 'Konstruksi' ? 'selected' : '' }}>
                                            Konstruksi</option>
                                        <option value="Sarana"
                                            {{ $category->classification == 'Sarana' ? 'selected' : '' }}>Sarana
                                        </option>
                                        <option value="Prasarana"
                                            {{ $category->classification == 'Prasarana' ? 'selected' : '' }}>Prasarana
                                        </option>
                                    </select>
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
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('select-all');
                const checkboxes = document.querySelectorAll('input[name="categories[]"]');

                selectAllCheckbox.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });
            });
        </script>
    @endpush
</x-layout-rab>
