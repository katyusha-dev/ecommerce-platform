<?php

namespace App\Providers;

use App\Nova\User;
use Laravel\Nova\Nova;
use Laravel\Nova\Menu\Menu;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        parent::boot();
    }
//        Nova::userMenu(function (Request $request, Menu $menu) {
//            if ($request->user()->subscribed()) {
//                $menu->append(
//                    MenuItem::make('Subscriber Dashboard')
//                        ->path('/subscribers/dashboard')
//                );
//            }
//
//            $menu->prepend(
//                MenuItem::make(
//                    'My Profile',
//                    "/resources/users/{$request->user()->getKey()}"
//                )
//            );
//
//            $menu->append(MenuItem::externalLink('Logout', 'https://api.yoursite.com/logout')
//                ->method(
//                    'POST',
//                    data: ['user' => 'hemp'],
//                    headers: ['API_TOKEN' => 'abcdefg1234567']
//                ));
//
//
//            $menu->append(MenuItem::externalLink('API Docs', 'http://example.com'))
//                ->prepend(MenuItem::link('My Profile', '/resources/users/'.$request->user()->getKey()));
//
//            return $menu;
//        });
//
//        Nova::mainMenu(function (Request $request) {
//            return [
//                MenuSection::make('Business', [
//                    MenuGroup::make('Licensing', [
//                        MenuItem::dashboard(Sales::class),
//                        MenuItem::resource(License::class),
//                        MenuItem::resource(License::class),
//                        MenuItem::externalLink('Stripe Payments', 'https://dashboard.stripe.com/payments?status%5B%5D=successful'),
//                    ]),
//                ]),
//
//                MenuSection::make('Customers', [
//                    MenuItem::resource(User::class),
//                ])->icon('user')->collapsable(),
//
//                MenuSection::make('Content', [
//                    MenuItem::resource(Series::class),
//                    MenuItem::resource(Release::class),
//                ])->icon('document-text')->collapsable(),
//            ];
//        });
//    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes() {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate() {
        Gate::define('viewNova', fn ($user) => true);
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards() {
        return [
            new \App\Nova\Dashboards\Main(),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools() {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
    }
}
