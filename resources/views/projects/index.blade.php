<x-body>
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-secondary">Proyek</a></li>
                </ul>

                <div class="text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32"
                            class="rounded-circle">
                    </a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Daftar Proyek Perumahan</h1>
                    <h2 class="fw-light">PT. AJISAKA</h2>
                </div>
            </div>
        </section>
        <section>
            <div class="container mx-3 mb-3">
                <button type="button" data-bs-toggle="modal" data-bs-target="#createProjectModal"
                    class="btn btn-primary col-md-2">Tambah
                    Proyek
                </button>
            </div>
            <div class="card p-3 mx-4">
                <h5>Tampilkan Berdasarkan :</h5>
                <div class="row">
                    <form method="GET" action="{{ route('projects.index') }}" class="row">
                        <div class="col-md-8">
                            <label for="search" class="mx-1 mb-2">Nama Proyek :</label>
                            <input type="search" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Cari Proyek">
                        </div>
                        <div class="col-md-4">
                            <label for="location" class="mx-1 mb-2">Lokasi :</label>
                            <select class="form-select" name="location">
                                <option value="">Pilih Lokasi</option>
                                <option value="Semarang" {{ request('location') == 'Semarang' ? 'selected' : '' }}>
                                    Semarang</option>
                                <option value="Pekalongan" {{ request('location') == 'Pekalongan' ? 'selected' : '' }}>
                                    Pekalongan</option>
                                <option value="Sumedang" {{ request('location') == 'Sumedang' ? 'selected' : '' }}>
                                    Sumedang</option>
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>

                </div>
        </section>
        <section>
            <div class="album py-5 bg-body-tertiary">
                <div class="container mx-3 mb-3">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        @foreach ($projects as $project)
                            <div class="col">
                                <div class="card shadow-sm">
                                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                                        xmlns="http://www.w3.org/2000/svg" role="img"
                                        aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice"
                                        focusable="false">
                                        <title>Placeholder</title>
                                        <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%"
                                            fill="#eceeef" dy=".3em">Thumbnail</text>
                                    </svg>
                                    <div class="card-body">
                                        <h4 class="text-center">{{ $project->project_name }}</h4>
                                        <p class="card-text">Lokasi : {{ $project->location }}</p>
                                        <p class="card-text">Tahun : {{ $project->year }}</p>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="btn-group">
                                                <a href="{{ route('projects.show', $project->project_id) }}">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary btn-primary text-light">Lihat
                                                    </button>
                                                </a>
                                                <a href="{{ route('projects.edit', $project->project_id) }}">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary btn-success text-light">Edit
                                                    </button></a>
                                                <form action="{{ route('projects.destroy', $project->project_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" name="submit"
                                                        class="btn btn-sm btn-outline-secondary text-light btn-danger">Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        </section>
    </main>
    <!-- Create Project Modal -->
    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProjectModalLabel">Buat Proyek Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="project_name" class="form-label">Nama Proyek</label>
                            <input type="text" class="form-control" id="project_name" name="project_name"
                                placeholder="Nama Proyek">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location"
                                placeholder="Lokasi">
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="year" name="year"
                                placeholder="Tahun">
                        </div>
                        <div class="mb-3">
                            <label for="image">Upload Gambar</label>
                            <input type="file" name="image" class="form-control" id="image">
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <input type="hidden" name="total_cost" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-body>
