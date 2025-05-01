<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectType extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function job_categories(): BelongsToMany
    {
        return $this->belongsToMany(JobCategory::class, 'rab_type', 'type_id', 'category_id')->withPivot('budget_plan');
    }
}
