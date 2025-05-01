<x-layout-rab title="Analisis Harga Satuan">
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Analisis Harga Satuan</h3>
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
                            <div class="alert alert-primary">
                                Total Biaya: Rp
                                {{ number_format(
                                    $jobData->materials->sum('pivot.total_cost') +
                                        $jobData->equipments->sum('pivot.total_cost') +
                                        $jobData->employees->sum('pivot.total_cost') +
                                        0.1 *
                                            ($jobData->materials->sum('pivot.total_cost') +
                                                $jobData->equipments->sum('pivot.total_cost') +
                                                $jobData->employees->sum('pivot.total_cost')),
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                @php
                                    $totalAll = 0;
                                @endphp

                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Koefisien</th>
                                            <th>Satuan</th>
                                            <th>Harga Dasar</th>
                                            <th>Harga Total</th>
                                            <th colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        {{-- Header BAHAN --}}
                                        <tr class="text-center">
                                            <th colspan="6">Bahan</th>
                                            <th colspan="2">
                                                <a href="{{ route('job-materials.select', $jobData->job_id) }}">
                                                    <i class="bi bi-plus-square-fill h5 float-center"></i>
                                                </a>
                                            </th>
                                        </tr>

                                        {{-- Isi Bahan --}}
                                        @foreach ($jobData->materials as $material)
                                            <tr id="row-{{ $material->material_id }}">
                                                <form
                                                    action="{{ route('job-materials.updateSingle', ['job_id' => $jobData->job_id, 'material_id' => $material->material_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <td>{{ $material->material_name }}</td>
                                                    <td>{{ $material->description }}</td>

                                                    {{-- Koefisien --}}
                                                    <td style="max-width: 100px;" class="text-center">
                                                        <span
                                                            class="koefisien-text text-center">{{ $material->pivot->koefisien }}</span>
                                                        <input type="number" step="0.01" min="0"
                                                            name="koefisien" value="{{ $material->pivot->koefisien }}"
                                                            class="form-control koefisien-input d-none text-center ">
                                                    </td>

                                                    <td class="text-center">{{ $material->material_unit }}</td>

                                                    {{-- Harga dasar --}}
                                                    <td class="text-end">Rp
                                                        {{ number_format($material->material_cost, 0, ',', '.') }}</td>

                                                    {{-- Harga total --}}
                                                    <td class="text-end harga-total">
                                                        Rp
                                                        {{ number_format($material->pivot->total_cost, 0, ',', '.') }}
                                                    </td>

                                                    {{-- Aksi --}}
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning btn-edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>

                                                        <button type="submit"
                                                            class="btn btn-sm btn-success btn-selesai d-none">
                                                            <i class="bi bi-check2"></i>
                                                        </button>

                                                    </td>
                                                </form>

                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('job-materials.destroy', ['job_id' => $jobData->job_id, 'material_id' => $material->material_id]) }}"
                                                        method="POST" onsubmit="return confirm('Hapus bahan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach


                                        {{-- Header ALAT --}}
                                        <tr class="text-center">
                                            <th colspan="6">Alat</th>
                                            <th colspan="2">
                                                <a href="{{ route('job-equipments.select', $jobData->job_id) }}">
                                                    <i class="bi bi-plus-square-fill h5 float-center"></i>
                                                </a>
                                            </th>
                                        </tr>

                                        {{-- Isi Alat --}}
                                        @foreach ($jobData->equipments as $equipment)
                                            <tr id="row-{{ $equipment->equipment_id }}">
                                                <form
                                                    action="{{ route('job-equipments.updateSingle', ['job_id' => $jobData->job_id, 'equipment_id' => $equipment->equipment_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <td>{{ $equipment->equipment_name }}</td>
                                                    <td>{{ $equipment->description }}</td>

                                                    {{-- Koefisien --}}
                                                    <td style="max-width: 100px;" class="text-center">
                                                        <span
                                                            class="koefisien-text text-center">{{ $equipment->pivot->koefisien }}</span>
                                                        <input type="number" step="0.01" min="0"
                                                            name="koefisien" value="{{ $equipment->pivot->koefisien }}"
                                                            class="form-control koefisien-input d-none text-center ">
                                                    </td>

                                                    <td class="text-center">{{ $equipment->equipment_unit }}</td>

                                                    {{-- Harga dasar --}}
                                                    <td class="text-end">Rp
                                                        {{ number_format($equipment->equipment_cost, 0, ',', '.') }}
                                                    </td>

                                                    {{-- Harga total --}}
                                                    <td class="text-end harga-total">
                                                        Rp
                                                        {{ number_format($equipment->pivot->total_cost, 0, ',', '.') }}
                                                    </td>

                                                    {{-- Aksi --}}
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning btn-edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success btn-selesai d-none">
                                                            <i class="bi bi-check2"></i>
                                                        </button>
                                                    </td>
                                                </form>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('job-equipments.destroy', ['job_id' => $jobData->job_id, 'equipment_id' => $equipment->equipment_id]) }}"
                                                        method="POST" onsubmit="return confirm('Hapus alat ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach

                                        {{-- Header PEKERJA --}}
                                        <tr class="text-center">
                                            <th colspan="6">Pekerja</th>
                                            <th colspan="2">
                                                <a href="{{ route('job-employees.select', $jobData->job_id) }}">
                                                    <i class="bi bi-plus-square-fill h5 float-center"></i>
                                                </a>
                                            </th>
                                        </tr>

                                        {{-- Isi Pekerja --}}
                                        @foreach ($jobData->employees as $employee)
                                            <tr id="row-{{ $employee->employee_id }}">
                                                <form
                                                    action="{{ route('job-employees.updateSingle', ['job_id' => $jobData->job_id, 'employee_id' => $employee->employee_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <td>{{ $employee->position }}</td>
                                                    <td></td>

                                                    {{-- Koefisien --}}
                                                    <td style="max-width: 100px;" class="text-center">
                                                        <span
                                                            class="koefisien-text text-center">{{ $employee->pivot->koefisien }}</span>
                                                        <input type="number" step="0.01" min="0"
                                                            name="koefisien"
                                                            value="{{ $employee->pivot->koefisien }}"
                                                            class="form-control koefisien-input d-none text-center ">
                                                    </td>

                                                    <td class="text-center">{{ $employee->unit }}</td>

                                                    {{-- Harga dasar --}}
                                                    <td class="text-end">Rp
                                                        {{ number_format($employee->wage, 0, ',', '.') }}
                                                    </td>

                                                    {{-- Harga total --}}
                                                    <td class="text-end harga-total">
                                                        Rp
                                                        {{ number_format($employee->pivot->total_cost, 0, ',', '.') }}
                                                    </td>

                                                    {{-- Aksi --}}
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-warning btn-edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success btn-selesai d-none">
                                                            <i class="bi bi-check2"></i>
                                                        </button>
                                                    </td>
                                                </form>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('job-employees.destroy', ['job_id' => $jobData->job_id, 'employee_id' => $employee->employee_id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Hapus pekerja ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach


                                        {{-- Total Perhitungan --}}
                                        @php
                                            $totalMaterial = $jobData->materials->sum(
                                                fn($item) => $item->pivot->total_cost ?? 0,
                                            );
                                            $totalEquipment = $jobData->equipments->sum(
                                                fn($item) => $item->pivot->total_cost ?? 0,
                                            );
                                            $totalEmployee = $jobData->employees->sum(
                                                fn($item) => $item->pivot->total_cost ?? 0,
                                            );

                                            $subtotal = $totalMaterial + $totalEquipment + $totalEmployee;
                                            $ppn = $subtotal * 0.1;
                                            $grandTotal = $subtotal + $ppn;
                                        @endphp

                                        <tr class="text-end">
                                            <th colspan="5">Total Biaya (Bahan + Alat + Pekerja)</th>
                                            <th>Rp {{ number_format($subtotal, 0, ',', '.') }}</th>
                                            <th></th>
                                        </tr>
                                        <tr class="text-end">
                                            <th colspan="5">Overhead & Profit (10%)</th>
                                            <th>Rp {{ number_format($ppn, 0, ',', '.') }}</th>
                                            <th></th>
                                        </tr>
                                        <tr class="fw-bold text-end">
                                            <th colspan="5">Total Biaya + Overhead</th>
                                            <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center my-3">
                                <a href="{{ route('jobs.updateTotalCost', $jobData->job_id) }}"
                                    class="btn btn-success">Selesai</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                row.querySelector('.koefisien-text').classList.add('d-none');
                row.querySelector('.koefisien-input').classList.remove('d-none');
                row.querySelector('.btn-edit').classList.add('d-none');
                row.querySelector('.btn-selesai').classList.remove('d-none');

                // Hitung ulang total saat input berubah
                const input = row.querySelector('.koefisien-input');
                input.addEventListener('input', () => {
                    const unitPrice = parseFloat(
                        row.children[4].textContent.replace(/[^\d]/g, '')
                    );
                    const koefisien = parseFloat(input.value);
                    const total = unitPrice * koefisien;

                    // row.querySelector('.harga-total').textContent = 'Rp ' + new Intl.NumberFormat(
                    //     'id-ID').format(total || 0);
                });
            });
        });
    </script>

</x-layout-rab>
