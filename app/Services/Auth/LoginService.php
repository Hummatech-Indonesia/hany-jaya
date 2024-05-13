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
    public function handleLogin($request, UserInterface $user): mixed
    {
        $data['email'] = $request->email;
        $user = $user->getWhere($data);
        if ($user->email_verified_at) {
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('home')->with('success', 'Berhasil Login.');
            } else {
                return redirect()->back()->withErrors(trans('auth.login_failed'))->withInput();
            }
        } else {
            return redirect()->back()->withErrors('Harap Verifikasi Akun Anda Terlebih Dahulu');
        }
    }
}
