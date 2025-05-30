<x-layout-rab title="Perhitungan RAB">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>RAB</h3>
                    <p class="text-subtitle text-muted">{{ $type->name }} -
                        {{ $type->type }}
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    @php
                        $user = Auth::user();
                    @endphp
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <h7>{{ $user->name }}</h7>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row" id="table-bordered">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap gap-2">
                            <div class="button">
                                <!-- Tombol untuk membuka modal -->
                                <div class="buttons">
                                    <a href="{{ route('categories.selectJobCategory', $type->type_id) }}">
                                        <button class="btn-success btn p-2" type="button">
                                            Tambah Pekerjaan
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="button">
                                <div class="buttons">
                                    <a href="{{ route('rab.viewPDF', $type->type_id) }}">
                                        <button class="btn-success btn p-2" type="button">
                                            Cetak RAB
                                        </button></a>
                                </div>
                            </div>
                            @php
                                $totalsByClassification = collect($jobCategories)
                                    ->groupBy('classification')
                                    ->map(function ($categories) use ($type) {
                                        return $categories
                                            ->flatMap(function ($category) use ($type) {
                                                return $category->job_types
                                                    ->where('type_id', $type->type_id)
                                                    ->flatMap(fn($jobType) => $jobType->sub_jobs);
                                            })
                                            ->sum(fn($sub) => $sub->total_volume * $sub->job_cost);
                                    });
                            @endphp
                        </div>
                        <div class="card-body">
                            <!-- table bordered -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Pekerjaan</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-bordered ">
                                        <tr>
                                            <td class="text-center">A</td>
                                            <td colspan="4" class="text-start"><strong>HARGA TANAH</strong></td>
                                            <td class="text-end">
                                                <strong>Rp {{ number_format($type->land_price, 0, ',', '.') }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <button style="color: orange" type="button" class="btn p-0"
                                                    data-bs-toggle="modal" data-bs-target="#editLandPriceModal">
                                                    <i class="bi bi-pencil-square h5"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- KONSTRUKSI BANGUNAN --}}
                                        <tr>
                                            <td class="text-center">B</td>
                                            <td colspan="6" class="text-start"><strong>KONSTRUKSI BANGUNAN
                                                    RUMAH</strong>
                                            </td>
                                        </tr>
                                        @foreach ($jobCategories->where('classification', 'Konstruksi') as $category)
                                            @php
                                                $no = 1;
                                                $jobTypeForThisCategory = $category->job_types
                                                    ->where('type_id', $type->type_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('rab.destroy', $jobTypeForThisCategory->jobtype_id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus kategori pekerjaan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button style="color: red" type="submit" name="submit"
                                                            class="btn p-0">
                                                            <i class="bi bi-x-circle-fill h5"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td colspan="5" class="text-start">
                                                    <strong>
                                                        @if ($jobTypeForThisCategory && !empty($jobTypeForThisCategory->rename))
                                                            {{ $jobTypeForThisCategory->rename }}
                                                        @else
                                                            {{ $category->category_name }}
                                                        @endif
                                                    </strong>
                                                </td>

                                                <td class="text-center">
                                                    <button style="color: orange" type="button" class="btn p-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal-{{ $category->category_id }}">
                                                        <i class="bi bi-pencil-square h5"></i>
                                                    </button>

                                                    @if ($jobTypeForThisCategory)
                                                        <a
                                                            href="{{ route('jobs.selectJob', ['jobtype_id' => $jobTypeForThisCategory->jobtype_id, 'type_id' => $type->type_id]) }}">
                                                            <button style="color: green" type="button" class="btn p-0">
                                                                <i class="bi bi-plus-square-fill h5"></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Nama Kategori -->
                                            <div class="modal fade"
                                                id="editCategoryModal-{{ $jobTypeForThisCategory->jobtype_id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('rab.renameCategory', $jobTypeForThisCategory->jobtype_id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning text-dark">
                                                                <h5 class="modal-title">Edit Nama Kategori</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <input type="text" name="jobtype_id"
                                                                        value="{{ $jobTypeForThisCategory->jobtype_id }}"
                                                                        hidden>
                                                                    <label for="rename" class="form-label">Nama
                                                                        Pekerjaan</label>
                                                                    <input type="text" class="form-control"
                                                                        name="rename"
                                                                        value="{{ $jobTypeForThisCategory->rename ?? $category->category_name }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal
                                                                </button>
                                                                <button type="submit"
                                                                    onclick="return confirm('Yakin ingin mengubah nama kategori ini?')"
                                                                    class="btn btn-warning">Simpan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @foreach ($category->job_types->where('type_id', $type->type_id) as $jobType)
                                                @foreach ($jobType->sub_jobs as $sub)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ $sub->rename ?? $sub->job->job_name }}</td>
                                                        <td class="text-center">{{ $sub->total_volume }}</td>
                                                        <td class="text-center">{{ $sub->job->satuan_volume }}</td>
                                                        <td class="text-end">
                                                            Rp {{ number_format($sub->job_cost, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-end">
                                                            Rp
                                                            {{ number_format($sub->total_volume * $sub->job_cost, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown">
                                                                    <i class="bi bi-list-ul"></i>
                                                                </button>

                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('jobs.priceAnalysis', $sub->sub_job_id) }}">Edit
                                                                            Harga
                                                                            Satuan</a></li>
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('volume.index', $sub->sub_job_id) }}">Edit
                                                                            Volume</a></li>
                                                                    <li>
                                                                        <button class="dropdown-item"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editJobModal-{{ $sub->sub_job_id }}">Edit
                                                                            Pekerjaan
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('rab.deleteJob', $sub->sub_job_id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Yakin ingin menghapus pekerjaan ini?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="dropdown-item text-danger"
                                                                                type="submit">Hapus</button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal Edit Pekerjaan -->
                                                    <div class="modal fade" id="editJobModal-{{ $sub->sub_job_id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editJobModalLabel-{{ $sub->sub_job_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST"
                                                                action="{{ route('rab.renameJob', $sub->sub_job_id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success text-white">
                                                                        <h5 class="modal-title"
                                                                            id="editJobModalLabel-{{ $sub->sub_job_id }}">
                                                                            Edit Pekerjaan -
                                                                            {{ $sub->job->job_name }}
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <input type="hidden" name="sub_job_id"
                                                                        value="{{ $sub->sub_job_id }}">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="rename"
                                                                                class="form-label">Nama
                                                                                Pekerjaan</label>
                                                                            <input type="text" name="rename"
                                                                                class="form-control" required
                                                                                value="{{ $sub->rename ?? $sub->job->job_name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Sub Jumlah
                                                        </strong></td>
                                                    <td colspan="1" class="text-end">
                                                        @php
                                                            $totalSubJobCost = collect($category->job_types)
                                                                ->flatMap(fn($jobType) => $jobType->sub_jobs)
                                                                ->sum(fn($sub) => $sub->total_volume * $sub->job_cost);
                                                        @endphp
                                                        <strong>Rp
                                                            {{ number_format($totalSubJobCost, 0, ',', '.') }}
                                                        </strong>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforeach

                                            <div class="modal fade" id="addJobModal-{{ $category->category_id }}"
                                                tabindex="-1"
                                                aria-labelledby="addJobModalLabel-{{ $category->category_id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST" action="{{ route('jobs.store') }}">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title"
                                                                    id="addJobModalLabel-{{ $category->category_id }}">
                                                                    Tambah Job - {{ $category->category_name }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="job_name" class="form-label">Nama
                                                                        Job</label>
                                                                    <input type="text" name="job_name"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="satuan_volume"
                                                                        class="form-label">Satuan</label>
                                                                    <input type="text" name="satuan_volume"
                                                                        class="form-control" required>
                                                                </div>
                                                                <input type="hidden" name="category_id"
                                                                    value="{{ $category->category_id }}">
                                                                <input type="hidden" name="total_cost"
                                                                    value="{{ $category->total_cost }}">
                                                                <input type="hidden" name="total_volume"
                                                                    value="{{ $category->total_volume }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>SUB TOTAL KONSTRUKSI</strong>
                                            </td>
                                            <td class="text-end">
                                                <strong>Rp
                                                    {{ number_format($totalsByClassification->get('Konstruksi', 0), 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td></td>
                                        </tr>

                                        {{-- SARANA RUMAH --}}
                                        <tr>
                                            <td class="text-center">C</td>
                                            <td colspan="6" class="text-start"><strong>SARANA RUMAH</strong>
                                            </td>
                                        </tr>
                                        @foreach ($jobCategories->where('classification', 'Sarana') as $category)
                                            @php
                                                $no = 1;
                                                $jobTypeForThisCategory = $category->job_types
                                                    ->where('type_id', $type->type_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('rab.destroy', $jobTypeForThisCategory->jobtype_id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus kategori pekerjaan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button style="color: red" type="submit" name="submit"
                                                            class="btn p-0">
                                                            <i class="bi bi-x-circle-fill h5"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td colspan="5" class="text-start">
                                                    <strong>
                                                        @if ($jobTypeForThisCategory && !empty($jobTypeForThisCategory->rename))
                                                            {{ $jobTypeForThisCategory->rename }}
                                                        @else
                                                            {{ $category->category_name }}
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <button style="color: orange" type="button" class="btn p-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal-{{ $category->category_id }}">
                                                        <i class="bi bi-pencil-square h5"></i>
                                                    </button>

                                                    @if ($jobTypeForThisCategory)
                                                        <a
                                                            href="{{ route('jobs.selectJob', ['jobtype_id' => $jobTypeForThisCategory->jobtype_id, 'type_id' => $type->type_id]) }}">
                                                            <button style="color: green" type="button"
                                                                class="btn p-0">
                                                                <i class="bi bi-plus-square-fill h5"></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>


                                            <!-- Modal Edit Nama Kategori -->
                                            <div class="modal fade"
                                                id="editCategoryModal-{{ $jobTypeForThisCategory->jobtype_id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('rab.renameCategory', $jobTypeForThisCategory->jobtype_id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning text-dark">
                                                                <h5 class="modal-title">Edit Nama Kategori</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <input type="text" name="jobtype_id"
                                                                        value="{{ $jobTypeForThisCategory->jobtype_id }}"
                                                                        hidden>
                                                                    <label for="rename" class="form-label">Nama
                                                                        Pekerjaan</label>
                                                                    <input type="text" class="form-control"
                                                                        name="rename"
                                                                        value="{{ $jobTypeForThisCategory->rename ?? $category->category_name }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal
                                                                </button>
                                                                <button type="submit"
                                                                    onclick="return confirm('Yakin ingin mengubah nama kategori ini?')"
                                                                    class="btn btn-warning">Simpan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @foreach ($category->job_types->where('type_id', $type->type_id) as $jobType)
                                                @foreach ($jobType->sub_jobs as $sub)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ $sub->rename ?? $sub->job->job_name }}</td>
                                                        <td class="text-center">{{ $sub->total_volume }}</td>
                                                        <td class="text-center">{{ $sub->job->satuan_volume }}</td>
                                                        <td class="text-end">
                                                            Rp {{ number_format($sub->job_cost, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-end">
                                                            Rp
                                                            {{ number_format($sub->total_volume * $sub->job_cost, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown">
                                                                    <i class="bi bi-list-ul"></i>
                                                                </button>

                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('jobs.priceAnalysis', $sub->sub_job_id) }}">Edit
                                                                            Harga
                                                                            Satuan</a></li>
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('volume.index', $sub->sub_job_id) }}">Edit
                                                                            Volume</a></li>
                                                                    <li>
                                                                        <button class="dropdown-item"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editJobModal-{{ $sub->sub_job_id }}">Edit
                                                                            Pekerjaan
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <form
                                                                            action="{{ route('rab.deleteJob', $sub->sub_job_id) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Yakin ingin menghapus pekerjaan ini?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="dropdown-item text-danger"
                                                                                type="submit">Hapus</button>
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Edit Pekerjaan -->
                                                    <div class="modal fade" id="editJobModal-{{ $sub->sub_job_id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editJobModalLabel-{{ $sub->sub_job_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST"
                                                                action="{{ route('rab.renameJob', $sub->sub_job_id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success text-white">
                                                                        <h5 class="modal-title"
                                                                            id="editJobModalLabel-{{ $sub->sub_job_id }}">
                                                                            Edit Pekerjaan -
                                                                            {{ $sub->job->job_name }}
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <input type="hidden" name="sub_job_id"
                                                                        value="{{ $sub->sub_job_id }}">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="rename"
                                                                                class="form-label">Nama
                                                                                Pekerjaan</label>
                                                                            <input type="text" name="rename"
                                                                                class="form-control" required
                                                                                value="{{ $sub->rename ?? $sub->job->job_name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Sub Jumlah
                                                        </strong></td>
                                                    <td colspan="1" class="text-end">
                                                        <strong>Rp
                                                            {{ number_format($totalSubJobCost, 0, ',', '.') }}
                                                        </strong>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforeach

                                            <div class="modal fade" id="addJobModal-{{ $category->category_id }}"
                                                tabindex="-1"
                                                aria-labelledby="addJobModalLabel-{{ $category->category_id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST" action="{{ route('jobs.store') }}">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title"
                                                                    id="addJobModalLabel-{{ $category->category_id }}">
                                                                    Tambah Job - {{ $category->category_name }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="job_name" class="form-label">Nama
                                                                        Job</label>
                                                                    <input type="text" name="job_name"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="satuan_volume"
                                                                        class="form-label">Satuan</label>
                                                                    <input type="text" name="satuan_volume"
                                                                        class="form-control" required>
                                                                </div>
                                                                <input type="hidden" name="category_id"
                                                                    value="{{ $category->category_id }}">
                                                                <input type="hidden" name="total_cost"
                                                                    value="{{ $category->total_cost }}">
                                                                <input type="hidden" name="total_volume"
                                                                    value="{{ $category->total_volume }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                        <tr>
                                            <td colspan="5" class="text-end">
                                                <strong>SUB TOTAL SARANA RUMAH</strong>
                                            </td>
                                            <td class="text-end"><strong>Rp
                                                    {{ number_format($totalsByClassification->get('Sarana', 0), 0, ',', '.') }}
                                                </strong></td>
                                            <td></td>
                                        </tr>


                                        {{-- PRASARANA RUMAH --}}
                                        <tr>
                                            <td class="text-center">D</td>
                                            <td colspan="6" class="text-start"><strong>PRASARANA RUMAH</strong>
                                            </td>
                                        </tr>
                                        @php
                                            // Hitung Total Prasarana Umum
                                            $prasaranaUmum = collect($jobCategories)
                                                ->where('classification', 'Prasarana')
                                                ->filter(
                                                    fn($category) => strtolower($category->category_name) ===
                                                        'fasilitas umum',
                                                )
                                                ->flatMap(function ($category) use ($type) {
                                                    return $category->job_types
                                                        ->where('type_id', $type->type_id)
                                                        ->flatMap(fn($jt) => $jt->sub_jobs);
                                                })
                                                ->sum(fn($sub) => $sub->total_volume * $sub->job_cost);

                                            $dividedCost =
                                                $type->project->capacity > 0
                                                    ? $prasaranaUmum / $type->project->capacity
                                                    : $prasaranaUmum;

                                            $dividedCost = $dividedCost ?? 0;

                                            // Hitung Sub Total Kategori Prasarana Non Umum
                                            $subtotalPrasarana = collect($jobCategories)
                                                ->where('classification', 'Prasarana')
                                                ->reject(
                                                    fn($category) => strtolower($category->category_name) ===
                                                        'fasilitas umum',
                                                )
                                                ->flatMap(function ($category) use ($type) {
                                                    return $category->job_types
                                                        ->where('type_id', $type->type_id)
                                                        ->flatMap(fn($jt) => $jt->sub_jobs);
                                                })
                                                ->sum(fn($sub) => $sub->total_volume * $sub->job_cost);

                                            $subtotalPrasarana = $subtotalPrasarana ?? 0;
                                        @endphp
                                        @foreach ($jobCategories->where('classification', 'Prasarana') as $category)
                                            @php
                                                $no = 1;
                                                $jobTypeForThisCategory = $category->job_types
                                                    ->where('type_id', $type->type_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('rab.destroy', $jobTypeForThisCategory->jobtype_id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus kategori pekerjaan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button style="color: red" type="submit" name="submit"
                                                            class="btn p-0">
                                                            <i class="bi bi-x-circle-fill h5"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td colspan="5" class="text-start">
                                                    <strong>
                                                        @if ($jobTypeForThisCategory && !empty($jobTypeForThisCategory->rename))
                                                            {{ $jobTypeForThisCategory->rename }}
                                                        @else
                                                            {{ $category->category_name }}
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <button style="color: orange" type="button" class="btn p-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal-{{ $jobTypeForThisCategory->jobtype_id }}">
                                                        <i class="bi bi-pencil-square h5"></i>
                                                    </button>

                                                    @if ($jobTypeForThisCategory)
                                                        <a
                                                            href="{{ route('jobs.selectJob', ['jobtype_id' => $jobTypeForThisCategory->jobtype_id, 'type_id' => $type->type_id]) }}">
                                                            <button style="color: green" type="button"
                                                                class="btn p-0">
                                                                <i class="bi bi-plus-square-fill h5"></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Nama Kategori -->
                                            <div class="modal fade"
                                                id="editCategoryModal-{{ $jobTypeForThisCategory->jobtype_id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('rab.renameCategory', $jobTypeForThisCategory->jobtype_id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning text-dark">
                                                                <h5 class="modal-title">Edit Nama Kategori</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <input type="text" name="jobtype_id"
                                                                        value="{{ $jobTypeForThisCategory->jobtype_id }}"
                                                                        hidden>
                                                                    <label for="rename" class="form-label">Nama
                                                                        Pekerjaan</label>
                                                                    <input type="text" class="form-control"
                                                                        name="rename"
                                                                        value="{{ $jobTypeForThisCategory->rename ?? $category->category_name }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal
                                                                </button>
                                                                <button type="submit"
                                                                    onclick="return confirm('Yakin ingin mengubah nama kategori ini?')"
                                                                    class="btn btn-warning">Simpan
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @foreach ($category->job_types->where('type_id', $type->type_id) as $jobType)
                                                @foreach ($jobType->sub_jobs as $sub)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ $sub->rename ?? $sub->job->job_name }}</td>
                                                        <td class="text-center">{{ $sub->total_volume }}</td>
                                                        <td class="text-center">{{ $sub->job->satuan_volume }}</td>
                                                        <td class="text-end">
                                                            Rp {{ number_format($sub->job_cost, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-end">
                                                            Rp
                                                            {{ number_format($sub->total_volume * $sub->job_cost, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown">
                                                                    <i class="bi bi-list-ul"></i>
                                                                </button>
                                                                @if ($category->category_name === 'Fasilitas Umum')
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <button class="dropdown-item"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#modalUpdateFasilitas{{ $sub->sub_job_id }}">Edit
                                                                                Harga Satuan
                                                                            </button>
                                                                        </li>
                                                                        <li>
                                                                            <button class="dropdown-item"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#editJobModal-{{ $sub->sub_job_id }}">Edit
                                                                                Pekerjaan
                                                                            </button>
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('rab.deleteJob', $sub->sub_job_id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Yakin ingin menghapus pekerjaan ini?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button
                                                                                    class="dropdown-item text-danger"
                                                                                    type="submit">Hapus</button>
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                @else
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('jobs.priceAnalysis', $sub->sub_job_id) }}">Edit
                                                                                Harga
                                                                                Satuan</a></li>
                                                                        <li><a class="dropdown-item"
                                                                                href="{{ route('volume.index', $sub->sub_job_id) }}">Edit
                                                                                Volume</a></li>
                                                                        <li>
                                                                            <button class="dropdown-item"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#editJobModal-{{ $sub->sub_job_id }}">Edit
                                                                                Pekerjaan
                                                                            </button>
                                                                        </li>
                                                                        <li>
                                                                            <form
                                                                                action="{{ route('rab.deleteJob', $sub->sub_job_id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Yakin ingin menghapus pekerjaan ini?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button
                                                                                    class="dropdown-item text-danger"
                                                                                    type="submit">Hapus</button>
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Edit Pekerjaan -->
                                                    <div class="modal fade" id="editJobModal-{{ $sub->sub_job_id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editJobModalLabel-{{ $sub->sub_job_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST"
                                                                action="{{ route('rab.renameJob', $sub->sub_job_id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success text-white">
                                                                        <h5 class="modal-title"
                                                                            id="editJobModalLabel-{{ $sub->sub_job_id }}">
                                                                            Edit Pekerjaan -
                                                                            {{ $sub->job->job_name }}
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <input type="hidden" name="sub_job_id"
                                                                        value="{{ $sub->sub_job_id }}">
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="rename"
                                                                                class="form-label">Nama
                                                                                Pekerjaan</label>
                                                                            <input type="text" name="rename"
                                                                                class="form-control" required
                                                                                value="{{ $sub->rename ?? $sub->job->job_name }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Update Fasilitas Umum -->
                                                    <div class="modal fade"
                                                        id="modalUpdateFasilitas{{ $sub->sub_job_id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="modalFasilitasLabel{{ $sub->sub_job_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form
                                                                action="{{ route('subjobs.updatePrasarana', $sub->sub_job_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="modalFasilitasLabel{{ $sub->sub_job_id }}">
                                                                            Update Fasilitas Umum</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label for="total_volume"
                                                                                    class="form-label">Volume
                                                                                </label>
                                                                                <input type="text"
                                                                                    name="total_volume"
                                                                                    class="form-control" required
                                                                                    value="{{ $sub->total_volume }}">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="job_cost"
                                                                                    class="form-label">Harga Satuan
                                                                                    (Rp)
                                                                                </label>
                                                                                <div class="input-group">
                                                                                    <span
                                                                                        class="input-group-text">Rp</span>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="uang-format-{{ $sub->sub_job_id }}"
                                                                                        step="0.01" required
                                                                                        placeholder="0">
                                                                                    <input type="hidden"
                                                                                        name="job_cost"
                                                                                        id="uang-asli-{{ $sub->sub_job_id }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-success">Simpan
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    {{-- Script Format Uang  --}}
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#uang-format-{{ $sub->sub_job_id }}').mask('000.000.000', {
                                                                reverse: true
                                                            });

                                                            $('form').on('submit', function() {
                                                                let uangFormatted = $('#uang-format-{{ $sub->sub_job_id }}').val();
                                                                let uangAsli = uangFormatted.replace(/\./g, '');
                                                                $('#uang-asli-{{ $sub->sub_job_id }}').val(uangAsli);
                                                            });
                                                        });
                                                    </script>
                                                @endforeach
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Sub Jumlah
                                                        </strong></td>
                                                    <td colspan="1" class="text-end">
                                                        <strong>Rp
                                                            {{ number_format($totalSubJobCost, 0, ',', '.') }}
                                                        </strong>
                                                    </td>

                                                    <td></td>
                                                </tr>
                                                @if ($category->category_name === 'Fasilitas Umum')
                                                    <tr>
                                                        <td class="text-end" colspan="5">
                                                            <strong>Harga per Unit
                                                            </strong>
                                                        </td>
                                                        <td class="text-end" colspan="1">
                                                            <strong>Rp
                                                                {{ number_format($dividedCost, 0, ',', '.') }}
                                                            </strong>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            <div class="modal fade" id="addJobModal-{{ $category->category_id }}"
                                                tabindex="-1"
                                                aria-labelledby="addJobModalLabel-{{ $category->category_id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST" action="{{ route('jobs.store') }}">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title"
                                                                    id="addJobModalLabel-{{ $category->category_id }}">
                                                                    Tambah Job - {{ $category->category_name }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="job_name" class="form-label">Nama
                                                                        Job</label>
                                                                    <input type="text" name="job_name"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="satuan_volume"
                                                                        class="form-label">Satuan</label>
                                                                    <input type="text" name="satuan_volume"
                                                                        class="form-control" required>
                                                                </div>
                                                                <input type="hidden" name="category_id"
                                                                    value="{{ $category->category_id }}">
                                                                <input type="hidden" name="total_cost"
                                                                    value="{{ $category->total_cost }}">
                                                                <input type="hidden" name="total_volume"
                                                                    value="{{ $category->total_volume }}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>SUB TOTAL PRASARANA</strong>
                                            </td>
                                            <td class="text-end">
                                                <strong>Rp
                                                    {{ number_format($subtotalPrasarana + $dividedCost, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7"></td>
                                        </tr>
                                        @php
                                            $totalHarga =
                                                $totalsByClassification->get('Konstruksi', 0) +
                                                $totalsByClassification->get('Sarana', 0) +
                                                $type->land_price +
                                                $subtotalPrasarana +
                                                $dividedCost;
                                            $ppn = $totalHarga * 0.1;
                                            $totalAkhir = $totalHarga + $ppn;
                                        @endphp
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>JUMLAH HARGA</strong></td>
                                            <td class="text-end"><strong>Rp
                                                    {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>ADMINISTRASI 10.00
                                                    %</strong>
                                            </td>
                                            <td class="text-end"><strong>Rp
                                                    {{ number_format($ppn, 0, ',', '.') }}</strong></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>TOTAL HARGA</strong></td>
                                            <td class="text-end"><strong>Rp
                                                    {{ number_format($totalAkhir, 0, ',', '.') }}</strong></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <form action="{{ route('rab.updateBudgetPlan', ['type_id' => $type->type_id]) }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="budget_plan" value="{{ $totalHarga }}">
                                    <input type="hidden" name="project_id"
                                        value="{{ $type->project->project_id }}">
                                    <button type="submit" class="btn btn-success">Selesai</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Edit Harga Tanah -->
    <div class="modal fade" id="editLandPriceModal" tabindex="-1" aria-labelledby="editLandPriceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('project-types.updateLandPrice', $type->type_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLandPriceModalLabel">Edit Harga Tanah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="land_price" class="form-label">Harga Tanah (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="uang-format" step="0.01" required
                                    placeholder="0">
                                <input type="hidden" name="land_price" id="uang-asli">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#uang-format').mask('000.000.000', {
                reverse: true
            });

            $('form').on('submit', function() {
                let uangFormatted = $('#uang-format').val();
                let uangAsli = uangFormatted.replace(/\./g, '');
                $('#uang-asli').val(uangAsli);
            });
        });
    </script>
</x-layout-rab>
