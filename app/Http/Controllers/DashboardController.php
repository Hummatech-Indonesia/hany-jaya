<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Cashier\BuyerInterface;
use App\Contracts\Interfaces\Cashier\DetailSellingInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Helpers\BaseResponse;
use App\Helpers\FormatMonth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private UserInterface $user;
    private SellingInterface $selling;
    private DetailSellingInterface $detailSelling;
    private ProductInterface $product;
    private BuyerInterface $buyer;
    public function __construct(UserInterface $user, SellingInterface $selling, ProductInterface $product, BuyerInterface $buyer, DetailSellingInterface $detailSelling)
    {
        $this->user = $user;
        $this->buyer = $buyer;
        $this->product = $product;
        $this->selling = $selling;
        $this->detailSelling = $detailSelling;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        $selling_count = $this->detailSelling->count(null);
        $selling_sum = $this->selling->sum(null);
        $debt = $this->buyer->sum(null);
        $buyers = $this->buyer->get();
        $product_count = $this->product->count(null);
        $year = FormatMonth::tahun();
        return view('dashboard.home.index', compact('selling_count', 'selling_sum', 'product_count', 'debt', 'buyers','year'));
    }

    public function listTahun()
    {
        return BaseResponse::Ok("Berhasil mengambil data tahun", FormatMonth::tahun());
    }
}
