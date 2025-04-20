<?php

namespace App\Http\Livewire;

namespace App\Http\Livewire;

use Livewire\Component;

class VolumeForm extends Component
{
    public $description;
    public $amount;
    public $length;
    public $width;
    public $height;
    public $wide;
    public $volume;

    public function updated($property)
    {
        // Reset unused fields
        if (in_array($property, ['length', 'width', 'height'])) {
            $this->wide = null;
            $this->volume = ($this->length && $this->width && $this->height)
                ? round($this->length * $this->width * $this->height, 2) : null;
        } elseif (in_array($property, ['wide', 'height'])) {
            $this->length = null;
            $this->width = null;
            $this->volume = ($this->wide && $this->height)
                ? round($this->wide * $this->height, 2) : null;
        } elseif ($property === 'volume') {
            $this->length = null;
            $this->width = null;
            $this->height = null;
            $this->wide = null;
        }
    }

    public function render()
    {
        return view('livewire.volume-form');
    }
}
