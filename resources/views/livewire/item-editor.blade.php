<tr>
    <td>{{ strtoupper($type) }}</td>
    <td>{{ $this->getName() }}</td>

    <td>
        @if ($editing)
            <input type="number" wire:model="koefisien" step="0.0001" class="form-control form-control-sm" />
        @else
            {{ number_format($koefisien, 4, ',', '.') }}
        @endif
    </td>

    <td>{{ $this->getUnit() }}</td>
    <td>Rp {{ number_format($this->getCost(), 2, ',', '.') }}</td>
    <td>Rp {{ number_format($totalCost, 2, ',', '.') }}</td>

    <td>
        @if ($editing)
            <button wire:click="update" class="btn btn-success btn-sm">✔️ Selesai</button>
            <button wire:click="cancelEdit" class="btn btn-warning btn-sm">✖️ Batal</button>
        @else
            <button wire:click="startEdit" class="btn btn-outline-primary btn-sm">✏️ Edit</button>
        @endif
    </td>
</tr>
