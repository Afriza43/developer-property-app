<?php

namespace App\Repositories\Interfaces;

interface RoleAccessRepositoryInterface
{
    public function getSiteAdminRole();
    public function register(array $data);
    public function getRoleAccessById($id);
    public function getRoleByProjectId($projectId);
    public function createRoleAccess(array $data);
    public function updateRoleAccess($id, array $data);
    public function deleteRoleAccess($id);
}
