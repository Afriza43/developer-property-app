<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{

    protected $table = 'job_types';
    protected $fillable = ['type_id', 'category_id', 'rename'];
    protected $primaryKey = 'jobtype_id';
    public $timestamps = false;

    public function sub_jobs()
    {
        return $this->hasMany(SubJob::class, 'jobtype_id', 'jobtype_id');
    }

    public function job_category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id', 'category_id');
    }

    public function project_type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id', 'type_id');
    }
}
