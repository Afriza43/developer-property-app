<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Progress Unit {{ $houseId }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/progress.css') }}">
</head>

<body>
    <div class="header">
        <h2>LAPORAN PROGRES PEMBANGUNAN</h2>
        <h1>PT. AJISAKA</h1>
    </div>

    <div class="info-section">
        <div class="info-row">
            <strong>Perumahan:</strong> {{ $progressReports->first()->house->project->project_name ?? '' }}
        </div>
        <div class="info-row">
            <strong>Rumah:</strong> {{ $progressReports->first()->house->name ?? '' }}
        </div>
        <div class="info-row">
            <strong>Tipe:</strong> {{ $progressReports->first()->house->type ?? '' }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 50%;">Keterangan Progress</th>
                <th style="width: 20%;">Minggu ke-</th>
                <th style="width: 25%;">Tanggal Laporan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($progressReports as $progress)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-left">{{ $progress->description }}</td>
                    <td class="text-center">{{ $progress->period }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($progress->report_date)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="header" style="page-break-before: always;">
        <h2>Bukti Pembangunan</h2>
    </div>

    <div class="image-grid">
        @foreach ($progressReports as $progress)
            <span style="margin-bottom: 6px; font-size: 12px;">
                {{ $progress->description }}
            </span>
            <br><br>
            @foreach ($progress->progress_photos as $photo)
                <img src="{{ asset('storage/' . $photo->image) }}" alt="Bukti Pembangunan"
                    style="width: 220px;
                        height: 220px;
                        object-fit: cover;
                        border: 1px solid #000000;
                        border-radius: 4px;">
            @endforeach
            <br>
            <hr>
        @endforeach
    </div>



    <div class="footer">
        <div class="print-info">
            Dicetak pada: {{ date('d F Y, H:i') }} WIB
        </div>
    </div>
</body>

</html>
