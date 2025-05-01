<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressPhoto extends Model
{
    protected $guarded = [];
    public $primaryKey = 'photo_id';
    public $table = 'progress_photos';

    public function progress_report()
    {
        return $this->belongsTo(ProgressReport::class, 'progress_reports_id');
    }
}
