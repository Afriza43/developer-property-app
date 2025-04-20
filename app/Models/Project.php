<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'project_id';
    public $timestamps = false;

    public function houses(): HasMany
    {
        return $this->hasMany(House::class, 'project_id');
    }
}
