<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rekapitulasi RAB</title>
    <link rel="stylesheet" href="{{ asset('assets/css/rab.css') }}" />
</head>

<body>
    <div class="header">REKAPITULASI RAB</div>

    <div class="project-info">
        <table>
            <tr>
                <td class="label">PEKERJAAN</td>
                <td>
                    :
                    <span id="pekerjaan">BANGUNAN RUMAH T.{{ $type->type }}</span>
                </td>
            </tr>
            <tr>
                <td class="label">LOKASI PROYEK</td>
                <td>
                    :
                    <span id="lokasi1">{{ $type->project->project_name }}</span><br />
                    :
                    <span id="lokasi2">{{ $type->project->location }}</span>
                </td>
            </tr>
            <tr>
                <td class="label">TAHUN</td>
                <td>
                    :
                    <span id="tahun">{{ $type->project->year }}</span>
                </td>
            </tr>
        </table>
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

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 40px">No.</th>
                <th style="width: 300px">URAIAN</th>
                <th style="width: 60px">Bobot</th>
                <th style="width: 120px">HARGA SATUAN</th>
                <th style="width: 120px">JUMLAH HARGA</th>
            </tr>
        </thead>
        <tbody>

            <tr class="section-header">
                <td class="center">A</td>
                <td><strong>KSB</strong></td>
                <td class="center"></td>
                <td class="center"></td>
                <td class="center"></td>
            </tr>
            <tr>
                <td class="center">1</td>
                <td>PENGADAAN TANAH</td>
                <td class="center"></td>
                <td class="currency">
                    Rp.
                    <span>{{ number_format($type->land_price, 0, ',', '.') }}</span>
                </td>
                <td class="currency">
                    Rp.
                    <span>{{ number_format($type->land_price, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr class="section-header">
                <td class="center">B</td>
                <td><strong>KONSTRUKSI BANGUNAN</strong></td>
                <td class="center">
                    <span>100%</span>
                </td>
                <td class="center"></td>
                <td class="currency">
                    Rp.
                    <span> {{ number_format($totalsByClassification->get('Konstruksi', 0), 0, ',', '.') }}</span>
                </td>
            </tr>
            @php
                $no = 1;
            @endphp
            @foreach ($jobCategories->where('classification', 'Konstruksi') as $category)
                @php
                    $jobTypeForThisCategory = $category->job_types->where('type_id', $type->type_id)->first();

                    $totalJobCost = collect($category->job_types)
                        ->flatMap(fn($jt) => $jt->sub_jobs)
                        ->sum(fn($sub) => $sub->total_volume * $sub->job_cost);

                    // Hitung Total Prasarana Umum
                    $prasaranaUmum = collect($jobCategories)
                        ->where('classification', 'Prasarana')
                        ->filter(fn($category) => strtolower($category->category_name) === 'fasilitas umum')
                        ->flatMap(function ($category) use ($type) {
                            return $category->job_types
                                ->where('type_id', $type->type_id)
                                ->flatMap(fn($jt) => $jt->sub_jobs);
                        })
                        ->sum(fn($sub) => $sub->total_volume * $sub->job_cost);

                    $dividedCost =
                        $type->project->capacity > 0 ? $prasaranaUmum / $type->project->capacity : $prasaranaUmum;

                    // Hitung Sub Total Kategori Prasarana Non Umum
                    $subtotalPrasarana = collect($jobCategories)
                        ->where('classification', 'Prasarana')
                        ->reject(fn($category) => strtolower($category->category_name) === 'fasilitas umum')
                        ->flatMap(function ($category) use ($type) {
                            return $category->job_types
                                ->where('type_id', $type->type_id)
                                ->flatMap(fn($jt) => $jt->sub_jobs);
                        })
                        ->sum(fn($sub) => $sub->total_volume * $sub->job_cost);
                @endphp
                <tr>
                    <td class="center">{{ $no++ }}</td>
                    <td class="subsection">
                        @if ($jobTypeForThisCategory && !empty($jobTypeForThisCategory->rename))
                            {{ $jobTypeForThisCategory->rename }}
                        @else
                            {{ $category->category_name }}
                        @endif
                    </td>
                    <td class="center">
                        <span>{{ number_format(($totalJobCost / $totalsByClassification->get('Konstruksi')) * 100, 0, ',', '.') }}%</span>
                    </td>
                    <td class="currency">
                        Rp.
                        <span>
                            {{ number_format($totalJobCost, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="center"></td>
                </tr>
            @endforeach
            <tr class="section-header">
                <td class="center">C</td>
                <td><strong>SARANA & PRASARANA RUMAH</strong></td>
                <td class="center"></td>
                <td class="currency">
                    Rp.
                    <span>{{ number_format($totalsByClassification->get('Sarana', 0) + $subtotalPrasarana + $dividedCost, 0, ',', '.') }}</span>
                </td>
                <td class="currency">
                    Rp.
                    <span>{{ number_format($totalsByClassification->get('Sarana', 0) + $subtotalPrasarana + $dividedCost, 0, ',', '.') }}</span>
                </td>
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
                $kelipatan = 100000;
                $totalPembulatan = ceil($totalAkhir / $kelipatan) * $kelipatan;
            @endphp
            <tr class="section-header">
                <td class="center">D</td>
                <td><strong>ADMINISTRASI</strong></td>
                <td class="center">
                    <span>10%</span>
                </td>
                <td class="currency">
                    Rp.
                    <span>{{ number_format($totalHarga, 0, ',', '.') }}</span>
                </td>
                <td class="currency">
                    Rp.
                    <span>{{ number_format($ppn, 0, ',', '.') }}</span>
                </td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="center">
                    <strong>Jumlah</strong>
                </td>
                <td class="center"></td>
                <td class="currency">
                    <strong>Rp.
                        <span id="total">{{ number_format($totalAkhir, 0, ',', '.') }}</span></strong>
                </td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="center">
                    <strong>Pembulatan</strong>
                </td>
                <td class="center"></td>
                <td class="currency">
                    <strong>Rp.
                        <span id="total">{{ number_format($totalPembulatan, 0, ',', '.') }}</span></strong>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
