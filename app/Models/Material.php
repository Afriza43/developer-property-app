<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey = 'material_id';

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_has_materials', 'material_id', 'job_id')
            ->withPivot('koefisien', 'total_cost');
    }
}
