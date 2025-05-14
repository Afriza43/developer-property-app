<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey = 'material_id';

    public function sub_jobs(): BelongsToMany
    {
        return $this->belongsToMany(SubJob::class, 'job_has_materials', 'material_id', 'sub_job_id')
            ->withPivot('koefisien', 'total_cost', 'material_cost');
    }
}
