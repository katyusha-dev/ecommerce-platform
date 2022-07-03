<?php

namespace Katyusha\Drivers\Payment;

    use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = true;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('payment', fn ($app) => new PaymentManager($app));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['payment'];
    }
}
