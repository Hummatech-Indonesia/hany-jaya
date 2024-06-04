<?php

namespace App\Providers;

use App\Contracts\Interfaces\Admin\CategoryInterface;
use App\Contracts\Interfaces\Admin\DetailPurchaseInterface;
use App\Contracts\Interfaces\Admin\ProductInterface;
use App\Contracts\Interfaces\Admin\ProductUnitInterface;
use App\Contracts\Interfaces\Admin\PurchaseInterface;
use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Contracts\Interfaces\Admin\SupplierProductInterface;
use App\Contracts\Interfaces\Admin\UnitInterface;
use App\Contracts\Interfaces\Cashier\DetailSellingInterface;
use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Repositories\Admin\CategoryRepository;
use App\Contracts\Repositories\Admin\DetailPurchaseRepository;
use App\Contracts\Repositories\Admin\ProductRepository;
use App\Contracts\Repositories\Admin\ProductUnitRepository;
use App\Contracts\Repositories\Admin\PurchaseRepository;
use App\Contracts\Repositories\Admin\SupplierProductRepository;
use App\Contracts\Repositories\Admin\SupplierRepository;
use App\Contracts\Repositories\Admin\UnitRepository;
use App\Contracts\Repositories\Cashier\DetailSellingRepository;
use App\Contracts\Repositories\Cashier\SellingRepository;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private array $register = [
        UserInterface::class => UserRepository::class,
        SupplierInterface::class => SupplierRepository::class,
        ProductInterface::class => ProductRepository::class,
        CategoryInterface::class => CategoryRepository::class,
        UnitInterface::class => UnitRepository::class,
        PurchaseInterface::class => PurchaseRepository::class,
        SupplierProductInterface::class => SupplierProductRepository::class,
        ProductUnitInterface::class => ProductUnitRepository::class,
        DetailPurchaseInterface::class => DetailPurchaseRepository::class,
        SellingInterface::class => SellingRepository::class,
        DetailSellingInterface::class => DetailSellingRepository::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->register as $index => $value) $this->app->bind($index, $value);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
