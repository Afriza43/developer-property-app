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

    public function sub_jobs(): HasMany
    {
        return $this->hasMany(SubJob::class, 'job_id');
    }
}
