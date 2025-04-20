<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseReport extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'expense_id';
    public $timestamps = false;

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class, 'house_id');
    }
}
