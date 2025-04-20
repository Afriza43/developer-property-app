<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th colspan="6">{{ $type }}
                <button class="btn btn-sm btn-success float-end">Tambah</button>
            </th>
        </tr>
        <tr>
            <th>Uraian</th>
            <th>Koefisien</th>
            <th>Satuan</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                {{-- Nama Item --}}
                <td>
                    @if ($type === 'Bahan')
                        {{ $item->material_name }}
                    @elseif ($type === 'Alat')
                        {{ $item->equipment_name }}
                    @elseif ($type === 'Pekerja')
                        {{ $item->position }}
                    @endif
                </td>

                {{-- Form input koefisien --}}
                <td>
                    <form method="POST"
                        action="{{ route('jobs.update' . ucfirst($routePrefix), [$jobData->id, $item->id]) }}">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="koefisien" value="{{ $item->pivot->koefisien }}" class="form-control">
                </td>

                {{-- Satuan --}}
                <td>
                    @if ($type === 'Bahan')
                        {{ $item->material_unit }}
                    @elseif ($type === 'Alat')
                        {{ $item->equipment_unit }}
                    @elseif ($type === 'Pekerja')
                        {{ $item->unit }}
                    @endif
                </td>

                {{-- Harga Satuan --}}
                <td>
                    @if ($type === 'Bahan')
                        {{ number_format($item->material_cost, 0, ',', '.') }}
                    @elseif ($type === 'Alat')
                        {{ number_format($item->equipment_cost, 0, ',', '.') }}
                    @elseif ($type === 'Pekerja')
                        {{ number_format($item->wage, 0, ',', '.') }}
                    @endif
                </td>

                {{-- Total Harga --}}
                <td>
                    <input type="number" name="total_cost" value="{{ $item->pivot->total_cost }}" class="form-control">
                </td>

                {{-- Tombol --}}
                <td>
                    <button class="btn btn-primary btn-sm">Simpan</button>
                    </form>
                </td>
            </tr>
        @endforeach

        {{-- Subtotal --}}
        <tr>
            <th colspan="3">Subtotal {{ $type }}</th>
            <th colspan="3">Rp {{ number_format($items->sum('pivot.total_cost'), 0, ',', '.') }}</th>
        </tr>
    </tbody>
</table>
