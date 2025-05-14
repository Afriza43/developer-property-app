<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey = 'equipment_id';
    public $table = 'equipments';

    public function sub_jobs()
    {
        return $this->belongsToMany(SubJob::class, 'job_has_equipments', 'equipment_id', 'sub_job_id')
            ->withPivot(['koefisien', 'equipment_cost', 'total_cost']);
    }
}
