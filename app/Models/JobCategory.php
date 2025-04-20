<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey = 'category_id';

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'category_id');
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class, 'house_id');
    }
}
