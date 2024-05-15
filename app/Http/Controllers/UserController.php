<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\UserInterface;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserInterface $user;
    private UserService $userService;

    public function __construct(UserInterface $user, UserService $userService)
    {
        $this->user = $user;
        $this->userService = $userService;
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $this->userService->store($request, $this->user);
        return redirect()->back(trans('alert.add_success'));
    }

    /**
     * update
     *
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $this->user->update($user->id, $data);
        return redirect()->back(trans('alert.update_success'));
    }
}
