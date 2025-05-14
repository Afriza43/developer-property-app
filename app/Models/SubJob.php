<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubJob extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'sub_job_id';
    public $timestamps = false;

    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'job_has_equipments', 'sub_job_id', 'equipment_id')
            ->withPivot(['koefisien', 'equipment_cost', 'total_cost']);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'job_has_employees', 'sub_job_id', 'employee_id')->withPivot('koefisien', 'total_cost', 'wage');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'job_has_materials', 'sub_job_id', 'material_id')->withPivot('koefisien', 'total_cost', 'material_cost');
    }

    public function volume_items(): HasMany
    {
        return $this->hasMany(VolumeItem::class, 'sub_job_id', 'sub_job_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id', 'job_id');
    }

    public function job_type(): BelongsTo
    {
        return $this->belongsTo(JobType::class, 'jobtype_id', 'jobtype_id');
    }
}
