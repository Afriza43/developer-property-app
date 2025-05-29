<x-body title="Daftar Tipe Rumah">
    <div class="page-heading">
        <h3>Tipe Perumahan {{ $project->project_name }}</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <form method="GET" action="{{ route('project-types.index', $projectId) }}" class="row mb-3">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="input-group mb-3">
                                <select class="form-select" name="selectType">
                                    <option value="">Pilih Tipe Rumah...</option>
                                    @php
                                        $allTypes = $types->pluck('type')->unique();
                                    @endphp
                                    @foreach ($allTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ request('selectType') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addTypeModal"
                                class="btn btn-success">Tambah Tipe</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section class="row">
            @foreach ($types as $type)
                <div class="col-md-4 col-sm-8">
                    <div class="card">
                        <div class="card-content">
                            @if ($type->image)
                                <img src="{{ asset('storage/' . $type->image) }}" class="card-img-top img-fluid"
                                    alt="Foto Tipe Rumah" style="height: 20rem; object-fit: cover;">
                            @else
                                <img class="card-img-top img-fluid"
                                    src="{{ asset('assets/image/Desain-Rumah-Subsidi.jpg') }}" alt="Template Rumah"
                                    style="height: 20rem; object-fit: cover;">
                            @endif

                            <div class="card-body">
                                <h4 class="card-title text-center">{{ $type->name }} - {{ $type->type }}</h4>
                                <ul class="p-2">
                                    <li class="list-group-item card-text py-1">
                                        <i class="bi bi-tags"></i> Tipe: {{ $type->type }}
                                    </li>
                                    <li class="list-group-item card-text py-1">
                                        <i class="bi bi-stickies"></i> Keterangan: {{ $type->identifier }}
                                    </li>
                                    <li class="list-group-item card-text py-1">
                                        <i class="bi bi-cash"></i> Total Anggaran:
                                        {{ number_format($type->total_budget, 0, ',', '.') }}
                                    </li>
                                </ul>
                                <hr>
                                <div class="d-flex justify-content-end">
                                    <form action="{{ route('project-types.copy-rab', $type->type_id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menyalin RAB ini?')">
                                        @csrf
                                        <button class="btn btn-success me-2" type="submit">
                                            <i class="bi bi-copy"></i>
                                            Copy
                                        </button>
                                    </form>

                                    {{-- Tombol untuk Detail --}}
                                    @role('teknik')
                                        <a href="{{ route('rab.index', ['type_id' => $type->type_id]) }}">
                                            <button class="btn btn-primary me-2" type="button">
                                                <i class="bi bi-file-earmark-spreadsheet"></i> RAB
                                            </button>
                                        </a>
                                    @endrole
                                    <button class="btn btn-warning me-2" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editTypeModal-{{ $type->type_id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    {{-- Tombol untuk Hapus --}}
                                    <form action="{{ route('project-types.destroy', $type->type_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit Tipe --}}
                    <div class="modal fade" id="editTypeModal-{{ $type->type_id }}" tabindex="-1"
                        aria-labelledby="editTypeModal-{{ $type->type_id }}Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('project-types.update', $type->type_id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editTypeModal-{{ $type->type_id }}Label">Edit Tipe
                                            Rumah
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Tipe</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $type->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Kode Tipe</label>
                                            <input type="text" class="form-control" id="type" name="type"
                                                value="{{ $type->type }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="identifier" class="form-label">Keterangan</label>
                                            <input type="text" class="form-control" id="identifier"
                                                name="identifier" value="{{ $type->identifier }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Gambar (Opsional)</label>
                                            <input type="file" name="image" class="form-control">
                                            @if ($type->image)
                                                <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin
                                                    mengganti
                                                    gambar.</small>
                                                <img src="{{ asset('storage/' . $type->image) }}" alt="Gambar Tipe"
                                                    class="img-fluid mt-2" style="max-height: 100px;">
                                            @endif
                                        </div>
                                        <input type="hidden" name="project_id" value="{{ $type->project_id }}">
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
    </div>

    <div class="d-flex justify-content-center mt-2 mb-5">
        <a href="{{ route('projects.index') }}">
            <button type="submit" class="btn btn-success">Selesai</button>
        </a>
    </div>

    {{-- Modal Tambah Tipe --}}
    <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('project-types.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTypeModalLabel">Edit Tipe Rumah
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Tipe</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Kode Tipe</label>
                            <input type="text" class="form-control" id="type" name="type" required>
                        </div>
                        <div class="mb-3">
                            <label for="identifier" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="identifier" name="identifier" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar (Opsional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <input type="hidden" name="project_id" value="{{ $projectId }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-body>
