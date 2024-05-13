<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\UserInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\LoginService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    private LoginService $loginService;
    private UserInterface $user;

    public function __construct(LoginService $loginService, UserInterface $user)
    {
        $this->loginService = $loginService;
        $this->user = $user;
    }

    /**
     * Handle user login.
     *
     * This function is responsible for handling user login requests.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request The incoming login request.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response.
     */
    public function login(LoginRequest $request)
    {
        return $this->loginService->handleLogin($request, $this->user);
    }

    /**
     * Handle user logout.
     *
     * This function is responsible for handling user logout requests. It deletes the current user's access token,
     * effectively logging the user out of the system.
     *
     * @return \Illuminate\Http\JsonResponse Returns a JSON response.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
