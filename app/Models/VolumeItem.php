<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolumeItem extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey = 'volume_items_id';

    public function sub_job(): BelongsTo
    {
        return $this->belongsTo(SubJob::class);
    }
}
