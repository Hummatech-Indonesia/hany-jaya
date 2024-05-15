<?php

namespace App\Providers;

use App\Models\Outlet;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\User;
use App\Observers\OutletObserver;
use App\Observers\StoreObserver;
use App\Observers\SupplierObserver;
use App\Observers\UserObserve;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Store::observe(StoreObserver::class);
        Outlet::observe(OutletObserver::class);
        User::observe(UserObserver::class);
        Supplier::observe(SupplierObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
