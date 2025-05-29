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
                    <span id="pekerjaan">BANGUNAN RUMAH T.36/72</span>
                </td>
            </tr>
            <tr>
                <td class="label">LOKASI PROYEK</td>
                <td>
                    :
                    <span id="lokasi1">Pamulihan Regency</span><br />
                    :
                    <span id="lokasi2">Ds. Pamulihan, Kec. Pamulihan, Kab. Sumedang</span>
                </td>
            </tr>
            <tr>
                <td class="label">TAHUN</td>
                <td>
                    :
                    <span id="tahun">2024</span>
                </td>
            </tr>
        </table>
    </div>

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
                <td class="center">I</td>
                <td>PENGADAAN TANAH</td>
                <td class="center"></td>
                <td class="currency">
                    Rp.
                    <span>72.000.000</span>
                </td>
                <td class="currency">
                    Rp.
                    <span>72.000.000</span>
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
                    <span>168.492.021</span>
                </td>
            </tr>
            @php
                $no = 1;
            @endphp
            @foreach ($jobCategories as $category)
                @php
                    // Ambil job_type spesifik untuk kategori ini dan project_type yang sedang aktif
                    $jobTypeForThisCategory = $category->job_types->where('type_id', $type->type_id)->first();
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
                        <span>4%</span>
                    </td>
                    <td class="currency">
                        Rp.
                        <span>
                            {{ number_format(
                                collect($category->job_types)->flatMap(fn($jt) => $jt->sub_jobs)->sum(fn($sub) => $sub->total_volume * $sub->job_cost),
                                0,
                                ',',
                                '.',
                            ) }}
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
                    <span>77.306.167</span>
                </td>
                <td class="currency">
                    Rp.
                    <span>77.306.167</span>
                </td>
            </tr>
            <tr class="section-header">
                <td class="center">D</td>
                <td><strong>ADMINISTRASI</strong></td>
                <td class="center">
                    <span>10%</span>
                </td>
                <td class="currency">
                    Rp.
                    <span>317.798.188</span>
                </td>
                <td class="currency">
                    Rp.
                    <span>31.779.819</span>
                </td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="center">
                    <strong>Jumlah</strong>
                </td>
                <td class="center"></td>
                <td class="currency">
                    <strong>Rp.
                        <span id="total">349.578.007</span></strong>
                </td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="center">
                    <strong>Pembulatan</strong>
                </td>
                <td class="center"></td>
                <td class="currency">
                    <strong>Rp. <span>349.600.000</span></strong>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="no-print">
        <button class="edit-button" onclick="toggleEdit()">
            Toggle Edit Mode
        </button>
        <button class="edit-button" onclick="window.print()">
            Print
        </button>
        <button class="edit-button" onclick="calculateTotal()">
            Hitung Total
        </button>
    </div>
</body>

</html>
