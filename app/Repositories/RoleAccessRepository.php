<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\RoleAccessRepositoryInterface;

class RoleAccessRepository implements RoleAccessRepositoryInterface
{
    public function getSiteAdminRole(): Role
    {
        return Role::findByName('site-admin', 'web');
    }
    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function getRoleAccessById($id)
    {
        return User::find($id);
    }

    public function getRoleByProjectId($projectId)
    {
        return User::with(['projects'])->whereHas('projects', function ($query) use ($projectId) {
            $query->where('user_access.project_id', $projectId);
        })->get();
    }

    public function createRoleAccess(array $data)
    {
        // Logic to create a new role access record
    }

    public function updateRoleAccess($id, array $data)
    {
        // Logic to update an existing role access record
    }

    public function deleteRoleAccess($id)
    {
        // Logic to delete a role access record
    }
}
