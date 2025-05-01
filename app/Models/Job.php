<?php

namespace App\Models;

use App\Models\VolumeItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey = 'job_id';

    public function job_categories(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'sub_jobs', 'job_id', 'category_id')->withPivot('job_cost');
    }

    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'job_has_equipments', 'job_id', 'equipment_id')
            ->withPivot('koefisien', 'total_cost', 'equipment_cost');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'job_has_employees', 'job_id', 'employee_id')->withPivot('koefisien', 'total_cost', 'wage');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'job_has_materials', 'job_id', 'material_id')->withPivot('koefisien', 'total_cost', 'material_cost');
    }

    public function volume_items(): HasMany
    {
        return $this->hasMany(VolumeItem::class, 'job_id', 'job_id');
    }
}
