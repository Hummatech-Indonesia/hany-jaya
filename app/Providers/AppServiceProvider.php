<?php

namespace App\Providers;

use App\Contracts\Interfaces\Admin\SupplierInterface;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Repositories\Admin\SupplierRepository;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private array $register = [
        UserInterface::class => UserRepository::class,
        SupplierInterface::class => SupplierRepository::class
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
        //
    }
}
