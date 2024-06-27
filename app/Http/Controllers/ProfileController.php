<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ProfileInterface;
use App\Http\Requests\ProfileRequest;
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
    public function index(): View
    {
        return view('dashboard.profile.index');
    }
    public function cashier():View{
        return view('dashboard.profile.cashier');
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
        return back()->with('success', 'Berhasil mengubah profil');
    }
}
