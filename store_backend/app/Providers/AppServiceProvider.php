<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        \Illuminate\Pagination\Paginator::useBootstrap();

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $cart = session()->get('cart', []);
            $count = 0;
            if (!empty($cart)) {
                $validProductIds = \App\Models\Product::whereIn('id', array_keys($cart))->pluck('id')->toArray();
                foreach ($cart as $id => $item) {
                    if (in_array($id, $validProductIds)) {
                        $count += $item['quantity'];
                    }
                }
            }
            $view->with('cart_count', $count);
        });
    }
}
