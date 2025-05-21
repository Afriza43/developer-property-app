<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\RoleAccessRepositoryInterface;

class RoleAccessController extends Controller
{
    public $roleAccessRepository;

    public function __construct(RoleAccessRepositoryInterface $roleAccessRepository)
    {
        $this->roleAccessRepository = $roleAccessRepository;
    }
    public function index(Request $request)
    {
        $projectId = $request->project_id;
        $roleAccess = $this->roleAccessRepository->getRoleByProjectId($projectId);

        return view('role-access.index', compact('projectId', 'roleAccess'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|unique:users,username|regex:/^[a-zA-Z0-9_-]+$/|max:15',
            'password' => 'required|max:15',
            'project_id' => 'required|exists:projects,project_id',
        ]);

        $user = $this->roleAccessRepository->register($validated);

        $user->assignRole('site-admin');

        $user->projects()->attach($validated['project_id']);

        return redirect()->route('role-access.index', ['project_id' => $validated['project_id']])->with('success', 'Role access created successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete an existing role access
        return redirect()->route('role-access.index')->with('success', 'Role access deleted successfully.');
    }
}
