<?php

namespace App\Services\Admin;

use App\Contracts\Interfaces\Admin\CostInterface;
use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\Admin\CostRequest;
use App\Models\Cost;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class CostService
{
    use UploadTrait;

    private SellingInterface $selling;
    private PurchaseInterface $purchase;
    private CostInterface $cost;

    public function __construct(SellingInterface $selling, PurchaseInterface $purchase,
    CostInterface $cost)
    {
        $this->selling = $selling;
        $this->purchase = $purchase;
        $this->cost = $cost;
    }

    public function store(CostRequest $request): array
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $imageUrl = $this->upload(UploadDiskEnum::PRODUCT->value, $request->file('image'));
        } else {
            $imageUrl = null;
        }

        return [
            'user_id' => auth()->user()->id,
            'desc' => $data['desc'],
            'loss_category_id' => $data['loss_category_id'],
            'price' => $data['price'],
            'image' => $imageUrl,
            'date' => $data['date']
        ];
    }

    /**
     * update
     *
     * @return array
     */
    public function update(CostRequest $request, Cost $cost): array
    {
        $data = $request->validated();

        $old_image = $cost->image;

        if ($request->hasFile('image')) {
            $this->remove($old_image);
            $old_image = $this->upload(UploadDiskEnum::COST->value, $request->file('image'));
        }

        $data = $request->validated();

        return [
            'edited_user_id' => auth()->user()->id,
            'desc' => $data['desc'],
            'loss_category_id' => $data['loss_category_id'],
            'price' => $data['price'],
            'image' => $old_image,
            'date' => $data['date'] ?? $cost->date
        ];
    }

    public function labaRugi(Request $request)
    {
        $type = $request->type;
        $tahun = $request->year ?? date('Y');
        $month = $request->month ?? date('m');

        $penjualan = $this->selling->sum([
            "column" => 'pay',
            "year" => $tahun,
            "month" => $type == "monthly" ? $month : null
        ]);

        $pembelian = $this->purchase->sum([
            "year" => $tahun,
            "month" => $type == "monthly" ? $month : null
        ]);

        $costs = $this->cost->sumCustom([
            "year" => $tahun,
            "month" => $type == "monthly" ? $month : null
        ]);

        $pengeluaran = $costs->sum("price");

        $data = (object)[
            "cost_price" => ["price" => $pembelian, "category" => "Pengeluaran Barang Jadi"],
            "income_price" => ["price" => $penjualan, "category" => "Penghasilan Barang Jadi"],
            "gross_price" => ["price" => $penjualan - $pembelian, "category" => "Laba Rugi Kotor"],
            "net_price" => ["price" => $penjualan - $pembelian - $pengeluaran, "category" => "Laba Rugi Bersih"],
            "others_price" => $costs->toArray()
        ];

        return $data;
    }
}
