<?php

namespace App\Services\Auth;

use App\Contracts\Interfaces\UserInterface;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Helpers\UserHelper;
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
        // dd($data);
        // set remember token
        $remember_token = null;
        if ($request->remember_me) {
            $remember_token = $data["remember_me"];
            unset($data["remember_me"]);
        }
        $password = $data["password"];
        unset($data["password"]);

        $user = $user->getWhere($data);
        if (auth()->attempt(['email' => $data['email'], 'password' => $password])) {
            if ($remember_token) $data["remember_me"] = $remember_token;
            if (isset($data['remember_me']) && !empty($data['remember_me'])) {
                setcookie("email", $data['email'], time() + 3600);
                setcookie("password", $password, time() + 3600);
            } else {
                setcookie("email", "");
                setcookie("password", "");
            }
            if (in_array(RoleEnum::ADMIN->value, auth()->user()->roles->pluck('name')->toArray())) {
                return redirect()->route('home')->with('success', 'Berhasil Login.');
            } else {
                return redirect()->route('cashier.index')->with('success', 'Berhasil Login');
            }
        } else {
            return redirect()->back()->withErrors('Password dan Email anda tidak sesuai')->withInput();
        }
    }
}
