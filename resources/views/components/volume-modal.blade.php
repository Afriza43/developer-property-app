@props(['jobId', 'volumeItem' => null, 'mode'])

@php
    $prefix = $mode === 'create' ? 'create' : 'edit-' . $volumeItem->volume_items_id;
    $route =
        $mode === 'create'
            ? route('volume.store', $jobId)
            : route('volume.update', ['job' => $jobId, 'volume' => $volumeItem->volume_items_id]);
    $method = $mode === 'create' ? 'POST' : 'PUT';
@endphp

<div class="modal fade"
    id="modal{{ ucfirst($mode) }}Volume{{ $mode === 'edit' ? '-' . $volumeItem->volume_items_id : '' }}" tabindex="-1"
    aria-labelledby="volumeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ $route }}" method="POST">
            @csrf
            @if ($mode === 'edit')
                @method('PUT')
            @endif
            <div class="modal-content volume-calc-group" data-prefix="{{ $prefix }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="volumeModalLabel">{{ $mode === 'create' ? 'Tambah' : 'Edit' }} Volume
                        Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Mode Hitung Volume</label>
                        <select class="form-select mode-select" id="{{ $prefix }}-mode" name="mode"
                            data-prefix="{{ $prefix }}">
                            <option value="lwh">Panjang × Lebar × Tinggi</option>
                            <option value="wh">Luas × Tinggi</option>
                            <option value="manual">Input Manual Volume</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label>Deskripsi</label>
                        <input type="text" name="description" class="form-control"
                            value="{{ $volumeItem->description ?? '' }}" required>
                    </div>

                    <div class="col-md-4">
                        <label>Panjang (m)</label>
                        <input type="number" step="0.01" name="length" id="{{ $prefix }}-length"
                            value="{{ $volumeItem->length ?? '' }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Lebar (m)</label>
                        <input type="number" step="0.01" name="width" id="{{ $prefix }}-width"
                            value="{{ $volumeItem->width ?? '' }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Tinggi (m)</label>
                        <input type="number" step="0.01" name="height" id="{{ $prefix }}-height"
                            value="{{ $volumeItem->height ?? '' }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Luas (m²)</label>
                        <input type="number" step="0.01" name="wide" id="{{ $prefix }}-wide"
                            value="{{ $volumeItem->wide ?? '' }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Volume (m³)</label>
                        <input type="number" step="0.01" name="volume_per_unit" id="{{ $prefix }}-volume"
                            value="{{ $volumeItem->volume_per_unit ?? '' }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Jumlah Item</label>
                        <input type="number" name="amount" class="form-control"
                            value="{{ $volumeItem->amount ?? 1 }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
