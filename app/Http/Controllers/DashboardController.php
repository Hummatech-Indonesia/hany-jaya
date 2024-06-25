<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private UserInterface $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }
    public function index(): View
    {
        $users = $this->user->getTopPurchase();
        return view('dashboard.home.index', compact('users'));
    }
}
