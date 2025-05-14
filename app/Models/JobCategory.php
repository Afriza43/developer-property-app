<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey = 'category_id';

    public function project_types()
    {
        return $this->belongsToMany(ProjectType::class, 'job_types', 'category_id', 'type_id')
            ->withPivot('jobtype_id');
    }

    public function job_types()
    {
        return $this->hasMany(JobType::class, 'category_id', 'category_id');
    }
}
