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

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_has_equipments', 'equipment_id', 'job_id')
            ->withPivot('koefisien', 'total_cost');
    }
}
