<x-layout-house title="Daftar Rumah">
    <div class="page-heading">
        <h2>Perumahan {{ $project->project_name }}</h2>
        <h6 class="text-muted">{{ $project->location }}</h6>
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
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldHome"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Rumah</h6>
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
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldMore-Square"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Blok</h6>
                                        <h6 class="font-extrabold mb-0">{{ $countBlok }}</h6>
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
                                            <i class="iconly-boldCategory"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Tipe</h6>
                                        <h6 class="font-extrabold mb-0">{{ $countType }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <h3 class="card-title col">
                            Daftar Rumah
                        </h3>
                        @role('keuangan')
                            <div class="col-auto d-flex justify-content-end">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#createHouseModal"
                                    class="btn btn-success">
                                    <i class="bi bi-plus-lg"></i> Tambah Rumah
                                </button>
                            </div>
                        @endrole
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Unit Rumah</th>
                                <th class="text-center">Tipe Rumah</th>
                                <th class="text-center">Anggaran</th>
                                <th class="text-center">Pengeluaran</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($houses as $house)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="text-center">{{ $house->name }}</td>
                                    <td class="text-center">{{ $house->type }}</td>
                                    <td class="text-center">
                                        {{ 'Rp ' . number_format($house->budget_plan, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        {{ $house->house_cost !== null ? 'Rp ' . number_format($house->house_cost, 0, ',', '.') : 'Rp 0' }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $profit = $house->profit_loss;
                                            $isLoss = $profit < 0;
                                            $class = $isLoss ? 'bg-danger text-white' : 'bg-success text-white';
                                            $label = $isLoss ? 'Rugi' : 'Untung';
                                        @endphp
                                        <span class="badge {{ $class }}">
                                            {{ $label }}: Rp {{ number_format(abs($profit), 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @role('site-admin')
                                            <a href="{{ route('expenses.index', ['house_id' => $house->house_id]) }}">
                                                <button type="button" class="btn btn-primary bg-blue">
                                                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                                                </button>
                                            </a>
                                        @endrole
                                        @role('keuangan|teknik')
                                            <a href="{{ route('houses.show', $house->house_id) }}">
                                                <button type="button" class="btn btn-primary bg-blue">
                                                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                                                </button>
                                            </a>
                                        @endrole
                                        @role('keuangan')
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editHouseModal-{{ $house->house_id }}"
                                                class="btn btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('houses.destroy', $house->house_id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus rumah ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        @endrole
                                    </td>

                                    {{-- Modal Edit Rumah --}}
                                    <div class="modal fade" id="editHouseModal-{{ $house->house_id }}" tabindex="-1"
                                        aria-labelledby="editHouseModal-{{ $house->house_id }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('houses.update', $house->house_id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editHouseModal-{{ $house->house_id }}Label">Edit Rumah
                                                        </h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="edit_block" class="form-label">Blok</label>
                                                            <input type="text" class="form-control"
                                                                id="edit_block" name="block" maxlength="8"
                                                                placeholder="Blok Rumah.."
                                                                value="{{ $house->block }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_number" class="form-label">Nomor</label>
                                                            <input type="text" class="form-control"
                                                                id="edit_number" name="number" maxlength="2"
                                                                placeholder="Nomor Rumah.."
                                                                value="{{ $house->number }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_type" class="form-label">Tipe</label>
                                                            <select class="form-control" id="edit_type"
                                                                name="type">
                                                                <option value="{{ $house->type }}" disabled selected>
                                                                    {{ $house->type }}</option>
                                                                @foreach ($project->project_types as $projectType)
                                                                    <option value="{{ $projectType->type }}"
                                                                        data-identifier="{{ $projectType->identifier }}">
                                                                        {{ $projectType->type }}
                                                                        {{ $projectType->identifier ? '(' . $projectType->identifier . ')' : '' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="hidden" class="form-control" id="project_id"
                                                            name="project_id" value="{{ $project->project_id }}">
                                                        <input type="hidden" value="{{ $house->house_cost }}"
                                                            class="form-control" id="house_cost" name="house_cost">
                                                        <input type="hidden" class="form-control" id="name"
                                                            name="name">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @role('keuangan|teknik')
                        <div class="d-flex justify-content-center mt-2 mb-3">
                            <a href="{{ route('projects.index') }}">
                                <button type="submit" class="btn btn-secondary">Kembali</button>
                            </a>
                        </div>
                    @endrole
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Tambah Rumah --}}
    <div class="modal fade" id="createHouseModal" tabindex="-1" aria-labelledby="createHouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createHouseModalLabel">Blok Rumah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="block" class="form-label">Blok</label>
                            <input type="text" class="form-control" id="block" name="block" maxlength="8"
                                placeholder="Blok Rumah..">
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label">Nomor</label>
                            <input type="text" class="form-control" id="number" name="number" maxlength="2"
                                placeholder="Nomor Rumah..">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe</label>
                            <select class="form-control" id="type" name="type">
                                <option value="" disabled selected>Pilih Tipe Rumah...</option>
                                @foreach ($project->project_types as $projectType)
                                    <option value="{{ $projectType->type }}"
                                        data-identifier="{{ $projectType->identifier }}">
                                        {{ $projectType->type }}
                                        {{ $projectType->identifier ? '(' . $projectType->identifier . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" class="form-control" id="project_id" name="project_id"
                            value="{{ $project->project_id }}">
                        <input type="hidden" class="form-control" id="house_cost" name="house_cost">
                        <input type="hidden" class="form-control" id="name" name="name">
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
</x-layout-house>
