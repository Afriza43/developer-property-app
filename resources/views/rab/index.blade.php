<x-layout-rab title="Perhitungan RAB">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>RAB</h3>
                    <p class="text-subtitle text-muted">{{ $house->name }}</p>
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
                                    <button type="button" class="btn-success btn p-2" data-bs-toggle="modal"
                                        data-bs-target="#addJobCategory">
                                        Tambah Kategori
                                    </button>
                                </div>

                                <!-- Modal -->
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
                                                    <input type="hidden" name="house_id"
                                                        value="{{ $house->house_id }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="button">
                                <div class="buttons">
                                    <a href="{{ route('materials.index', ['house_id' => $house->house_id]) }}">
                                        <button class="btn-success btn p-2" type="button">
                                            Daftar Material
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="button">
                                <div class="buttons">
                                    <a href="{{ route('equipments.index', ['house_id' => $house->house_id]) }}">
                                        <button class="btn-success btn p-2" type="button">
                                            Daftar
                                            Alat
                                        </button></a>
                                </div>
                            </div>
                            <div class="button">
                                <div class="buttons">
                                    <a href="{{ route('employees.index', ['house_id' => $house->house_id]) }}">
                                        <button class="btn-success btn p-2" type="button">
                                            Daftar
                                            Pekerja
                                        </button></a>
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
                        <div class="card-content">
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
                                                        {{ number_format(collect($category->jobs)->sum(fn($job) => $job->total_volume * $job->total_cost), 0, ',', '.') }}
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <button style="color: orange" type="button" class="btn p-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCategoryModal-{{ $category->category_id }}">
                                                        <i class="bi bi-pencil-square h5"></i>
                                                    </button>
                                                    <button style="color: green" type="button" class="btn p-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#addJobModal-{{ $category->category_id }}">
                                                        <i class="bi bi-plus-square-fill h5"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            @foreach ($category->jobs as $job)
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>{{ $job->job_name }}</td>
                                                    <td class="text-center">{{ $job->total_volume }}</td>
                                                    <td class="text-center">{{ $job->satuan_volume }}</td>
                                                    <td class="text-end">
                                                        Rp {{ number_format($job->total_cost, 0, ',', '.') }}</td>
                                                    <td class="text-end">
                                                        Rp
                                                        {{ number_format($job->total_volume * $job->total_cost, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-primary dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown">
                                                                <i class="bi bi-list-ul"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('jobs.priceAnalysis', $job->job_id) }}">Edit
                                                                        Harga
                                                                        Satuan</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('volume.index', $job->job_id) }}">Edit
                                                                        Volume</a></li>
                                                                <li>
                                                                    <button class="dropdown-item"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editJobModal-{{ $job->job_id }}">Edit
                                                                        Pekerjaan
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('jobs.destroy', $job->job_id) }}"
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
                                                <!-- Modal -->
                                                <div class="modal fade" id="editJobModal-{{ $job->job_id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="editJobModalLabel-{{ $job->job_id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST"
                                                            action="{{ route('jobs.update', $job->job_id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-success text-white">
                                                                    <h5 class="modal-title"
                                                                        id="editJobModalLabel-{{ $job->job_id }}">
                                                                        Edit Pekerjaan - {{ $job->job_name }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="job_name" class="form-label">Nama
                                                                            Pekerjaan</label>
                                                                        <input type="text" name="job_name"
                                                                            class="form-control" required
                                                                            value="{{ $job->job_name }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="satuan_volume"
                                                                            class="form-label">Satuan</label>
                                                                        <input type="text" name="satuan_volume"
                                                                            class="form-control" required
                                                                            value="{{ $job->satuan_volume }}">
                                                                    </div>
                                                                    <input type="hidden" name="category_id"
                                                                        value="{{ $job->category_id }}">
                                                                    <input type="hidden" name="total_cost"
                                                                        value="{{ $job->total_cost }}">
                                                                    <input type="hidden" name="total_volume"
                                                                        value="{{ $job->total_volume }}">
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
                                            <!-- Modal Tambah Job per Kategori -->
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
                                            <!-- Modal Edit Job Kategori -->
                                            <div class="modal fade"
                                                id="editCategoryModal-{{ $category->category_id }}" tabindex="-1"
                                                aria-labelledby="editCategoryModal-{{ $category->category_id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST"
                                                        action="{{ route('rab.update', $category->category_id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success text-white">
                                                                <h5 class="modal-title"
                                                                    id="editCategoryModal-{{ $category->category_id }}">
                                                                    Edit Kategori - {{ $category->category_name }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="category_name" class="form-label">Nama
                                                                        Kategori</label>
                                                                    <input type="text" name="category_name"
                                                                        class="form-control"
                                                                        value="{{ $category->category_name }}"
                                                                        required>
                                                                </div>
                                                                <input type="hidden" name="category_cost"
                                                                    value="0">
                                                                <input type="hidden" name="house_id"
                                                                    value="{{ $house->house_id }}">
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
                                            $totalHarga = $jobCategories->sum(function ($category) {
                                                return collect($category->jobs)->sum(function ($job) {
                                                    return $job->total_volume * $job->total_cost;
                                                });
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
                            <div class="text-center my-3">
                                <a href="{{ route('houses.index', ['project_id' => $house->project->project_id]) }}"
                                    class="btn btn-success">Selesai</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layout-rab>
