<tr>
    <td>
        <input type="text" name="description" class="form-control" wire:model.defer="description" required>
    </td>
    <td>
        <input type="number" name="amount" class="form-control" wire:model.defer="amount" required>
    </td>
    <td>
        <input type="number" step="0.01" name="length" class="form-control" wire:model="length"
            {{ $wide || $volume ? 'disabled' : '' }}>
    </td>
    <td>
        <input type="number" step="0.01" name="width" class="form-control" wire:model="width"
            {{ $wide || $volume ? 'disabled' : '' }}>
    </td>
    <td>
        <input type="number" step="0.01" name="height" class="form-control" wire:model="height"
            {{ $volume ? 'disabled' : '' }}>
    </td>
    <td>
        <input type="number" step="0.01" name="wide" class="form-control" wire:model="wide"
            {{ $length || $width || $volume ? 'disabled' : '' }}>
    </td>
    <td>
        <input type="text" name="volume" class="form-control" wire:model="volume"
            {{ ($length && $width && $height) || ($wide && $height) ? 'readonly' : '' }}>
    </td>
    <td>
        <button type="submit" class="btn btn-sm btn-success">Tambah</button>
    </td>
</tr>
