<x-body title="Daftar Perumahan">
    <div class="page-heading">
        <h3>Perumahan Ajisaka</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center align-items-center">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldWork"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Perumahan</h6>
                                        <h6 class="font-extrabold mb-0">{{ $countProject }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center align-items-center">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldHome"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Unit</h6>
                                        <h6 class="font-extrabold mb-0">{{ $countHouses }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center align-items-center">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldDiscovery"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Lokasi</h6>
                                        <h6 class="font-extrabold mb-0">{{ $countLocation }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div
                                        class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center align-items-center">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldWallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Total Pengeluaran</h6>
                                        <h6 class="font-extrabold mb-0">{{ $sumCost }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="GET" action="{{ route('projects.index') }}" class="row mb-3">
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <div class="input-group mb-3">
                                <input type="search" name="search" class="form-control"
                                    placeholder="Cari Perumahan..." aria-label="Nama Perumahan"
                                    aria-describedby="button-addon2" value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-3">
                                <select class="form-select" id="basicSelect" name="selectLocation">
                                    <option>Cari Lokasi...</option>
                                    @foreach ($projects as $loc)
                                        <option value="{{ $loc->location }}"
                                            {{ request('selectLocation') == $loc->location ? 'selected' : '' }}>
                                            {{ $loc->location }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @role('keuangan')
                            <div class="col-md-2">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#createProjectModal"
                                    class="btn btn-success d-flex items-center justify-content-center">Tambah
                                    Perumahan
                                </button>
                            </div>
                        @endrole
                    </div>
                </form>
            </div>
        </section>
    </div>
    <section class="row">
        @foreach ($projects as $project)
            <div class="col-md-4 col-sm-8">

                <div class="card">
                    <div class="card-content">
                        @if ($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top img-fluid"
                                alt="Foto Perumahan" style="height: 20rem; object-fit: cover;">
                        @else
                            <img class="card-img-top img-fluid"
                                src="{{ asset('assets/image/Desain-Rumah-Subsidi.jpg') }}" alt="Rumah Template"
                                style="height: 20rem; object-fit: cover;">
                        @endif

                        <div class="card-body">
                            <h4 class="card-title text-center">{{ $project->project_name }}</h4>
                            <ul class="p-2">
                                <li class="list-group-item card-text py-1">
                                    <i class="bi bi-geo-alt-fill me-2"></i> Lokasi: {{ $project->location }}
                                </li>
                                <li class="list-group-item card-text py-1">
                                    <i class="bi bi-calendar-fill me-2"></i> Tahun: {{ $project->year }}
                                </li>
                                <li class="list-group-item card-text py-1">
                                    <i class="bi bi-house-fill me-2"></i> Kapasitas Unit: {{ $project->capacity }}
                                </li>
                            </ul>
                            <hr>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('project-types.index', ['project_id' => $project->project_id]) }}">
                                    <button class="btn btn-info me-2">
                                        <i class="bi bi-house"></i> Tipe
                                    </button>
                                </a>

                                <a href="{{ route('houses.index', ['project_id' => $project->project_id]) }}">
                                    <button class="btn btn-primary me-2">
                                        <i class="bi bi-eye-fill"></i> Kelola
                                    </button>
                                </a>
                                @role('keuangan')
                                    <button class="btn btn-warning me-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editProjectModal-{{ $project->project_id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <form action="{{ route('projects.destroy', $project->project_id) }}" method="POST"
                                        onsubmit="return confirm('Hapus perumahan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                @endrole
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Edit Perumahan --}}
                <div class="modal fade" id="editProjectModal-{{ $project->project_id }}" tabindex="-1"
                    aria-labelledby="editProjectModal-{{ $project->project_id }}Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('projects.update', $project->project_id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProjectModal-{{ $project->project_id }}Label">
                                        Tambah
                                        Perumahan Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="project_name" class="form-label">Nama Perumahan</label>
                                        <input type="text" class="form-control" id="project_name"
                                            name="project_name" value="{{ $project->project_name }}"
                                            placeholder="Nama Perumahan..." required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control" id="location" name="location"
                                            value="{{ $project->location }}" placeholder="Lokasi..." required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" id="year" name="year"
                                            value="{{ $project->year }}" placeholder="Tahun..." required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="capacity" class="form-label">Kapasitas Rumah</label>
                                        <input type="number" class="form-control" id="capacity" name="capacity"
                                            value="{{ $project->capacity }}" placeholder="Kapasitas Rumah..."
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image">Upload Gambar</label>
                                        <input type="file" name="image"
                                            class="form-control @error('image') is-invalid @enderror" id="image">
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if ($project->image)
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti
                                                gambar
                                                saat ini.</small>
                                            <div style="margin-top: 10px;">
                                                {{-- <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#imagePreviewModal"
                                                data-image-url="{{ asset('storage/' . $project->image) }}">
                                                Pratinjau Gambar
                                            </button> --}}

                                                {{-- <img src="{{ asset('storage/' . $project->image) }}" class="img-fluid"
                                                alt="Pratinjau Gambar"> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="total_cost" value="">
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
            </div>
        @endforeach
    </section>

    {{-- Modal Tambah Perumahan --}}
    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProjectModalLabel">Tambah Perumahan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="project_name" class="form-label">Nama Perumahan</label>
                            <input type="text" class="form-control" id="project_name" name="project_name"
                                placeholder="Nama Perumahan..." required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location"
                                placeholder="Lokasi..." required>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="year" name="year"
                                placeholder="Tahun..." required>
                        </div>
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Kapasitas Rumah</label>
                            <input type="number" class="form-control" id="capacity" name="capacity"
                                placeholder="Kapasitas Rumah..." required>
                        </div>
                        <div class="mb-3">
                            <label for="image">Upload Gambar</label>
                            <input type="file" name="image"
                                class="form-control @error('image') is-invalid @enderror" id="image">
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

</x-body>
