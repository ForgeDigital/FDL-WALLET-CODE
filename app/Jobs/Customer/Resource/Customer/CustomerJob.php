<?php

namespace App\Jobs\Customer\Resource\Customer;

use App\Http\Requests\Customer\Resource\Customer\CustomerRequest;
use App\Http\Resources\Customer\Resource\Customer\CustomerResource;
use App\Models\Customer\Resource\Customer\Customer;
use App\Models\Customer\Resource\IDData\IDData;
use App\Services\kyc\SmileIdentityService;
use App\Traits\apiResponseBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\JsonResponse;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

class CustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, apiResponseBuilder;
    private CustomerRequest $theRequest;
    private SmileIdentityService $SmileIdentityService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( CustomerRequest $CustomerRequest )
    {
        $this -> theRequest = $CustomerRequest;
        $this -> SmileIdentityService = new SmileIdentityService();
    }

    /**
     * Execute the job.
     *
     * @return CustomerResource|JsonResponse
     */
    public function store() : CustomerResource|JsonResponse
    {
        // Perform KYC verification
        $verifyKYC = $this -> SmileIdentityService -> verifyCustomer([ "country" => $this -> theRequest -> input( 'data.relationships.country.attributes.country' ), "id_type" => $this -> theRequest -> input( 'data.attributes.id_type' ), "id_number" => $this -> theRequest -> input( 'data.attributes.id_number' )]);
        if ( $verifyKYC['ResultCode'] == 1012 )
        {
            // Create and store new customer after KYC verification
            $customer = new Customer(
            [
                'resource_id' => $this -> theRequest -> input( 'data.attributes.resource_id' ),

                'first_name' => $verifyKYC['FullData']['FirstName'],
                'middle_name' => $verifyKYC['FullData']['MiddleName'],
                'last_name' => $verifyKYC['FullData']['LastName'],

                'dob' => $verifyKYC['DOB'],
                'gender' => $verifyKYC['Gender'],

                'country' => $verifyKYC['Country'],
                'address' => $verifyKYC['Address'],
                'primary_phone' => $verifyKYC['PhoneNumber'],
                'secondary_phone' => $verifyKYC['PhoneNumber2'],
            ]);
            $customer -> save();

            // Store the ID Data for the customer and associate the relationship
            $idData = new IDData(
            [
                'resource_id' => generateAlphaNumericResource(15),
                'customer_id' => $customer -> id,

                'type' => $verifyKYC['IDType'],
                'number' => $verifyKYC['IDNumber'],

                'first_name' => $verifyKYC['FullData']['FirstName'],
                'middle_name' => $verifyKYC['FullData']['MiddleName'],
                'last_name' => $verifyKYC['FullData']['LastName'],

                'gender' => $verifyKYC['FullData']['Gender'],
                'nationality' => $verifyKYC['FullData']['Nationality'],

                'date_of_birth' => $verifyKYC['FullData']['DateOfBirth'],
                'place_of_birth' => $verifyKYC['FullData']['PlaceOfBirth'],

                'place_of_issue' => $verifyKYC['FullData']['PlaceOfIssue'],

                'issue_date' => $verifyKYC['FullData']['IssueDate'],
                'expiry_date' => $verifyKYC['FullData']['ExpiryDate'],

                'country' => $verifyKYC['Country'],

                'picture' => $verifyKYC['FullData']['Picture'],
            ]);
            $idData -> save();

            $idData -> customer() -> associate( $customer -> id );

            $customer -> refresh();
            return $this -> successResponse( ( new CustomerResource( $customer ) ), "Success", "Customer verification successful.", Response::HTTP_CREATED );
        }
        else
        {
            return $this -> successResponse( array(), "Error", $verifyKYC['ResultText'], Response::HTTP_BAD_REQUEST );
        }
    }
}
