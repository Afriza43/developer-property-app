<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'name',
        'username',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    public function username()
    {
        return 'username';
    }
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'user_access', 'user_id', 'project_id');
    }

    public function getKeyName()
    {
        return 'user_id';
    }
}
