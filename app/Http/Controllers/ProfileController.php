<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ProfileInterface;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Store;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private ProfileInterface $profile;
    private ProfileService $service;

    public function __construct(ProfileInterface $profile, ProfileService $service)
    {
        $this->profile = $profile;
        $this->service = $service;
    }
    /**
     * Method index
     *
     * @return View
     */
    /**
     * Method index
     *
     * @return View
     */
    public function index(): View
    {
        $store = Store::first();
        return view('dashboard.profile.index', compact('store'));
    }
    /**
     * Method cashier
     *
     * @return View
     */
    public function cashier(): View
    {
        $store = Store::first();
        return view('dashboard.profile.cashier', compact('store'));
    }
    /**
     * Method update
     *
     * @param User $user [explicite description]
     * @param ProfileRequest $request [explicite description]
     *
     * @return RedirectResponse
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        $this->profile->update(auth()->user()->id, $this->service->update($request));
        if(auth()->user()->hasRole('admin')){
            $store = Store::first();
            $store->update(['code_debt' => $request->code ?? $store->code_debt]);
        }
        return back()->with('success', 'Berhasil mengubah profil');
    }
    /**
     * Method changePassword
     *
     * @param PasswordRequest $request [explicite description]
     *
     * @return RedirectResponse
     */
    public function changePassword(PasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $this->profile->update(auth()->user()->id, $data);
        return back()->with('success', 'Berhasil mengubah password');
    }
}
