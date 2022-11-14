<?php

namespace App\Providers;

use App\Repository\Customer\Resource\Customer\CustomerRepository;
use App\Repository\Customer\Resource\Customer\CustomerRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() : void
    {
        $this -> app -> bind( CustomerRepositoryInterface::class, CustomerRepository::class );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() : void
    {
        //
    }
}
