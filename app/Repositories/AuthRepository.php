<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements \App\Repositories\Interfaces\AuthRepositoryInterface
{
    public function login(array $credentials)
    {
        return Auth::attempt($credentials);
    }
}
