<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('projects.index')->with('info', 'Anda sudah login.');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'regex:/^[a-zA-Z0-9_-]+$/', 'max:15'],
            'password' => ['required'],
        ]);

        if ($this->authRepository->login($credentials)) {
            $request->session()->regenerate();

            /** @var \App\Models\User */
            $user = Auth::user();

            if ($user->hasRole('site-admin')) {
                $project = $user->projects()
                    ->whereHas('users', function ($query) use ($user) {
                        $query->where('users.user_id', $user->user_id);
                    })
                    ->first();
                if ($project) {
                    return redirect()->route('houses.index', ['project_id' => $project->project_id])->with('success', 'Berhasil login.');
                } else {
                    return redirect()->route('projects.index')->with('success', 'Berhasil login.');
                }
            }

            return redirect()->route('projects.index')->with('success', 'Berhasil login.');
        }

        return back()->withErrors([
            'username' => 'Username salah.',
            'password' => 'Password salah.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    public function changeData(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'username' => 'required|unique:users,username|regex:/^[a-zA-Z0-9_-]+$/|max:15',
            'password' => 'required|max:15',
        ]);

        $user = $this->authRepository->getUserById($request->user_id);

        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->password = bcrypt($validated['password']);
        $user->save();

        return redirect()->route('role-access.index')->with('success', 'Role access updated successfully.');
    }
}
