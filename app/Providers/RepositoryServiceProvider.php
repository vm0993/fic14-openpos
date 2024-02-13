<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //Setup
        $this->app->bind(
            \App\Core\Interface\SetupInterface::class,
            \App\Core\Repository\SetupRepository::class);

        //Outlets
        $this->app->bind(
            \App\Core\Interface\Outlets\OutletEmployeeInterface::class,
            \App\Core\Repository\Outlets\OutletRepository::class);
        $this->app->bind(
            \App\Core\Interface\Outlets\EmployeeInterface::class,
            \App\Core\Repository\Outlets\EmployeeRepository::class);
        $this->app->bind(
            \App\Core\Interface\Outlets\PromoInterface::class,
            \App\Core\Repository\Outlets\PromoRepository::class);

        //Master
        $this->app->bind(
            \App\Core\Interface\Master\CategoryInterface::class,
            \App\Core\Repository\Master\CategoryRepository::class);
        $this->app->bind(
            \App\Core\Interface\Master\UnitInterface::class,
            \App\Core\Repository\Master\UnitRepository::class);
        $this->app->bind(
            \App\Core\Interface\Master\CustomerInterface::class,
            \App\Core\Repository\Master\CustomerRepository::class);
        $this->app->bind(
            \App\Core\Interface\Master\ItemInterface::class,
            \App\Core\Repository\Master\ItemRepository::class);
        $this->app->bind(
            \App\Core\Interface\Master\IngradiantInterface::class,
            \App\Core\Repository\Master\IngradiantRepository::class);

        //Pos [Multiple Outlet]
        $this->app->bind(
            \App\Core\Interface\Pos\SaleInterface::class,
            \App\Core\Repository\Pos\SaleRepository::class);

        //Stock Monitoring & Stock Controlling
        $this->app->bind(
            \App\Core\Interface\Inventorys\ItemIncomingInterface::class,
            \App\Core\Repository\Inventorys\ItemIncomingRepository::class);
        $this->app->bind(
            \App\Core\Interface\Inventorys\ItemOpnameInterface::class,
            \App\Core\Repository\Inventorys\ItemOpnameRepository::class);

        //Accounting

        //Report

        //Setting
        $this->app->bind(
            \App\Core\Interface\Settings\CompanyInterface::class,
            \App\Core\Repository\Settings\CompanyRepository::class);
        $this->app->bind(
            \App\Core\Interface\Settings\ItemDefaultInterface::class,
            \App\Core\Repository\Settings\ItemDefaultRepository::class);
        $this->app->bind(
            \App\Core\Interface\Settings\PermissionGroupInterface::class,
            \App\Core\Repository\Settings\PermissionGroupRepository::class);
        $this->app->bind(
            \App\Core\Interface\Settings\UserInterface::class,
            \App\Core\Repository\Settings\UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
