<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ItemEditor extends Component
{
    public $item;
    public $type;

    public $koefisien = 0;
    public $editing = false;

    public function mount($item, $type)
    {
        $this->item = $item;
        $this->type = $type;
        $this->koefisien = $item->pivot->koefisien ?? 0;
    }

    public function startEdit()
    {
        $this->editing = true;
    }

    public function cancelEdit()
    {
        $this->koefisien = $this->item->pivot->koefisien ?? 0;
        $this->editing = false;
    }

    public function update()
    {
        $this->item->pivot->koefisien = $this->koefisien;
        $this->item->pivot->total_cost = $this->koefisien * $this->getCost();
        $this->item->pivot->save();

        $this->editing = false;
    }

    public function getName()
    {
        return $this->item[$this->type . '_name'];
    }

    public function getCost()
    {
        return $this->item[$this->type . '_cost'];
    }

    public function getUnit()
    {
        return $this->item[$this->type . '_unit'];
    }

    public function getTotalCostProperty()
    {
        return $this->koefisien * $this->getCost();
    }

    public function render()
    {
        return view('livewire.item-editor');
    }
}
