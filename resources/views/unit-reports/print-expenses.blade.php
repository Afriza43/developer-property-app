<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengeluaran Unit {{ $houseId }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/progress.css') }}">
</head>

<body>
    <div class="header">
        <h2>LAPORAN PENGELUARAN PEMBANGUNAN</h2>
        <h1>PT. AJISAKA</h1>
    </div>

    <div class="info-section">
        <div class="info-row">
            <strong>Perumahan:</strong> {{ $expenseReports->first()->house->project->project_name ?? '' }}
        </div>
        <div class="info-row">
            <strong>Rumah:</strong> {{ $expenseReports->first()->house->name ?? '' }}
        </div>
        <div class="info-row">
            <strong>Tipe:</strong> {{ $expenseReports->first()->house->type ?? '' }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 45%;">Keterangan</th>
                <th style="width: 25%;">Tanggal Pembelian</th>
                <th style="width: 25%;">Total Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($expenseReports as $expense)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-left">{{ $expense->description }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($expense->purchase_date)) }}</td>
                    <td class="text-right">Rp {{ number_format($expense->total_expense, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" class="text-center">TOTAL KESELURUHAN</td>
                <td class="text-right">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <div class="header" style="page-break-before: always;">
        <h2>Bukti Pengeluaran</h2>
    </div>

    <div class="image-grid">
        @foreach ($expenseReports as $expense)
            <img style="width: 220px;
                        height: 220px;
                        object-fit: cover;
                        border: 1px solid #000000;
                        border-radius: 4px;"
                src="{{ asset('storage/' . $expense->evidence) }}" alt="Bukti Pengeluaran">
        @endforeach
    </div>

    <div class="footer">
        <div class="print-info">
            Dicetak pada: {{ date('d F Y, H:i') }} WIB
        </div>
    </div>
</body>

</html>
