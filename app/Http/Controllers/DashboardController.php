<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Contracts\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private UserInterface $user;
    private SellingInterface $selling;
    private ProductInterface $product;
    public function __construct(UserInterface $user, SellingInterface $selling, ProductInterface $product)
    {
        $this->user = $user;
        $this->product = $product;
        $this->selling = $selling;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        $selling_count = $this->selling->count(null);
        $selling_sum = $this->selling->sum(null);
        $product_count = $this->product->count(null);
        $users = $this->user->getTopPurchase();
        return view('dashboard.home.index', compact('users', 'selling_count', 'selling_sum', 'product_count'));
    }
}
