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
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <h7>User</h7>
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
                                    <a href="#">
                                        <button class="btn-success btn p-2" type="button">
                                            Cetak RAB
                                        </button></a>
                                </div>
                            </div>

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
                                        @foreach ($jobCategories as $category)
                                            @php $no = 1; @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <form action="{{ route('rab.destroy', $category->category_id) }}"
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
                                                <td colspan="4" class="text-start">
                                                    <strong>{{ $category->category_name }}</strong>
                                                </td>
                                                <td class="text-end">
                                                    <strong>Rp
                                                        {{ number_format(
                                                            collect($category->job_types)->flatMap(fn($jt) => $jt->sub_jobs)->sum(fn($sub) => $sub->total_volume * $sub->job_cost),
                                                            0,
                                                            ',',
                                                            '.',
                                                        ) }}
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <button style="color: orange" type="button" class="btn p-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal-{{ $category->category_id }}">
                                                        <i class="bi bi-pencil-square h5"></i>
                                                    </button>
                                                    @php
                                                        // Ambil job_type spesifik untuk kategori ini dan project_type yang sedang aktif
                                                        $jobTypeForThisCategory = $category->job_types
                                                            ->where('type_id', $type->type_id)
                                                            ->first();
                                                    @endphp
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

                                            @foreach ($category->job_types->where('type_id', $type->type_id) as $jobType)
                                                @foreach ($jobType->sub_jobs as $sub)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ $sub->job->job_name }}</td>
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
                                                                            action="{{ route('jobs.destroy', $sub->job_id) }}"
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
                                                    <div class="modal fade" id="editJobModal-{{ $sub->job_id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editJobModalLabel-{{ $sub->job_id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST"
                                                                action="{{ route('jobs.update', $sub->job_id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-success text-white">
                                                                        <h5 class="modal-title"
                                                                            id="editJobModalLabel-{{ $sub->job_id }}">
                                                                            Edit Pekerjaan - {{ $sub->job_name }}
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="job_name"
                                                                                class="form-label">Nama
                                                                                Pekerjaan</label>
                                                                            <input type="text" name="job_name"
                                                                                class="form-control" required
                                                                                value="{{ $sub->job_name }}">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="satuan_volume"
                                                                                class="form-label">Satuan</label>
                                                                            <input type="text" name="satuan_volume"
                                                                                class="form-control" required
                                                                                value="{{ $sub->satuan_volume }}">
                                                                        </div>
                                                                        <input type="hidden" name="category_id"
                                                                            value="{{ $sub->category_id }}">
                                                                        <input type="hidden" name="total_cost"
                                                                            value="{{ $sub->total_cost }}">
                                                                        <input type="hidden" name="total_volume"
                                                                            value="{{ $sub->total_volume }}">
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
                                        @php
                                            $totalHarga = collect($jobCategories)->sum(function ($category) {
                                                return collect($category->job_types)
                                                    ->flatMap(fn($jobType) => $jobType->sub_jobs)
                                                    ->sum(fn($sub) => $sub->total_volume * $sub->job_cost);
                                            });
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
                                            <td colspan="5" class="text-end"><strong>PAJAK 10.00
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
                                    <input type="hidden" name="budget_plan" value="{{ $totalAkhir }}">
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
</x-layout-rab>


{{-- <!-- Modal -->
<div class="modal fade" id="addJobCategory" tabindex="-1"
aria-labelledby="addJobCategoryLabel" aria-hidden="true">
<div class="modal-dialog">
    <form method="POST" action="{{ route('rab.store') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addJobCategoryLabel">Tambah Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Nama
                        Kategori</label>
                    <input type="text" name="category_name" class="form-control"
                        required>
                </div>
                <input type="hidden" name="category_cost" value="0">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>
</div>
</div> --}}
