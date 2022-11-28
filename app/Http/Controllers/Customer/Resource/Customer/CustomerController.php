<?php

namespace App\Http\Controllers\Customer\Resource\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Resource\Customer\CustomerRequest;
use App\Http\Resources\Customer\Resource\Customer\CustomerResource;
use App\Models\Customer\Resource\Customer\Customer;
use App\Repositories\Customer\Resource\Customer\CustomerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    private CustomerRepositoryInterface $theRepository;

    /**
     * @param CustomerRepositoryInterface $CustomerRepositoryInterface
     */
    public function __construct( CustomerRepositoryInterface $CustomerRepositoryInterface )
    {
        $this -> theRepository = $CustomerRepositoryInterface;
    }

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
        return $this -> theRepository -> store( $CustomerRequest );
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
