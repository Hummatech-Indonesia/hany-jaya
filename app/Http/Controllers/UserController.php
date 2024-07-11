<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Admin\RoleInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Repositories\RoleRepository;
use App\Helpers\BaseDatatable;
use App\Helpers\BaseResponse;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserInterface $user;
    private UserService $userService;
    private RoleInterface $role;

    public function __construct(UserInterface $user, UserService $userService, RoleRepository $role)
    {
        $this->user = $user;
        $this->userService = $userService;
        $this->role = $role;
    }

    public function index(Request $request): View
    {
        $users = $this->user->get($request);
        $roles = $this->role->getRoles();
        return view('dashboard.user.index', compact('users', 'roles'));
    }

    /**
     * getCashier
     *
     * @return View
     */
    public function getCashier(Request $request): View
    {
        $cashiers = $this->user->getCashier($request);
        return view('dashboard.user.index', compact('cashiers'));
    }

    /**
     * getAdmin
     *
     * @param  mixed $request
     * @return View
     */
    public function getAdmin(Request $request): View
    {
        $admins = $this->user->getAdmin($request);
        return view('dashboard.user.admin', compact('admins'));
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
        return redirect()->back()->with('success', trans('alert.add_success'));
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
        $user->syncRoles($data['role']);

        return redirect()->back()->with('success', trans('alert.update_success'));
    }

    /**
     * destroy
     *
     * @param  mixed $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->user->delete($user->id);
        return redirect()->back()->with('success', trans('alert.delete_success'));
    }

    /**
     * Data table list user cashier
     * 
     * @return DataTable
     */
    public function tableCashier(Request $request)
    {
        $user = $this->user->with(["roles" => function ($query) {
            $query->select('name');
        }]);
        return BaseDatatable::TableV2($user->toArray());
    }

    // get api for user
    public function findUser(Request $request): JsonResponse
    {
        $data = $this->user->getWhere([
            "email" => $request->email
        ]);
        return BaseResponse::Ok("Berhasil mengambil data user",$data);
    }
}
