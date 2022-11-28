<?php

namespace App\Repositories\Customer\Resource\Customer;

use App\Http\Requests\Customer\Resource\Customer\CustomerRequest;
use App\Http\Resources\Customer\Resource\Customer\CustomerResource;
use App\Jobs\Customer\Resource\Customer\CustomerJob;
use App\Models\Customer\Resource\Customer\Customer;

use App\Traits\apiResponseBuilder;
use App\Traits\Relatives;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CustomerRepository implements CustomerRepositoryInterface
{
    use apiResponseBuilder, Relatives;

    /**
     * Display a listing of the resource.
     *
     * @return CustomerResource|JsonResponse
     */
    public function index() : CustomerResource|JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $CustomerRequest
     * @return CustomerResource|JsonResponse
     */
    public function store( CustomerRequest $CustomerRequest ) : CustomerResource|JsonResponse
    {
        try
        {
            return ( new CustomerJob( $CustomerRequest ) ) -> store();
        }
        catch ( Throwable $Throwable )
        {
            return $this -> errorResponse( null, 'Error', $Throwable -> getMessage(), Response::HTTP_SERVICE_UNAVAILABLE );
            return $this -> errorResponse( null, 'Error', 'Service is unavailable, please retry again later.', Response::HTTP_SERVICE_UNAVAILABLE );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $Customer
     * @return CustomerResource|JsonResponse
     */
    public function show( Customer $Customer ) : CustomerResource|JsonResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $CustomerRequest
     * @param Customer $Customer
     * @return CustomerResource|JsonResponse
     */
    public function update( CustomerRequest $CustomerRequest, Customer $Customer ) : CustomerResource|JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $Customer
     * @return CustomerResource|JsonResponse
     */
    public function destroy( Customer $Customer ) : CustomerResource|JsonResponse
    {
        //
    }
}
