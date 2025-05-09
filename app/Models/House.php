<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class House extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'house_id';
    public $timestamps = false;

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function expense_reports(): HasMany
    {
        return $this->hasMany(ExpenseReport::class, 'house_id');
    }

    public function progress_reports(): HasMany
    {
        return $this->hasMany(ProgressReport::class, 'house_id');
    }
}
