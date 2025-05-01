<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobCategory extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey = 'category_id';

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'sub_jobs', 'category_id', 'job_id')->withPivot('job_cost');
    }

    public function project_types(): BelongsToMany
    {
        return $this->belongsToMany(JobCategory::class, 'rab_type', 'category_id', 'type_id')->withPivot('budget_plan');
    }
}
