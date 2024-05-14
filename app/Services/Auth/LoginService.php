<?php

namespace App\Services\Auth;

use App\Contracts\Interfaces\UserInterface;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Http\Requests\LoginRequest;

class LoginService
{
    /**
     * handleLogin
     *
     * @param  mixed $request
     * @return mixed
     */
    public function handleLogin(LoginRequest $request, UserInterface $user): mixed
    {
        $data = $request->validated();
        $data['email'] = $data['email'];
        $user = $user->getWhere($data);
        if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            if (isset($data['remember_me']) && !empty($data['remember_me'])) {
                setcookie("email", $data['email'], time() + 3600);
                setcookie("password", $data['password'], time() + 3600);
            } else {
                setcookie("email", "");
                setcookie("password", "");
            }
            return redirect()->route('home')->with('success', 'Berhasil Login.');
        } else {
            return redirect()->back()->withErrors('Password dan Email anda tidak sesuai')->withInput();
        }
    }
}
