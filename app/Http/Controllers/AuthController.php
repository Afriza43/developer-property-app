<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email|max:30',
            'password' => 'required',
        ]);

        if ($this->authRepository->login($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('projects.index')->with('success', 'Berhasil login.');
        }

        return back()->withErrors([
            'email' => 'Email salah.',
            'password' => 'Password salah.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
