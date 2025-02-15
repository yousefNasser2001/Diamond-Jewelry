<?php

namespace App\Providers;

use App\Models\Contributor;
use App\Models\Currency;
use App\Models\CurrencyDelar;
use App\Models\Debt;
use App\Models\Employee;
use App\Models\GoldDelar;
use App\Observers\ContributorObserver;
use App\Observers\DebtObserver;
use App\Observers\DelarObserver;
use App\Observers\EmployeeObserver;
use App\Observers\GoldDelarObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $employees = Employee::all();
            $currencies = Currency::all();

            $view->with(compact('employees', 'currencies'));
        });

        Employee::observe(EmployeeObserver::class);
        CurrencyDelar::observe(DelarObserver::class);
        Contributor::observe(ContributorObserver::class);
        Debt::observe(DebtObserver::class);
        GoldDelar::observe(GoldDelarObserver::class);

    }
}
