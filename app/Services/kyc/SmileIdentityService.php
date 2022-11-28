<?php

namespace App\Services\kyc;

use Illuminate\Support\Facades\Http;

class SmileIdentityService
{

    private $partner_id, $timestamp, $signature;

    /**
     * SmileIdentityService constructor.
     */
    public function __construct()
    {
        $sigData = $this -> generateSignature();

        $this -> partner_id = env( 'SMILE_ID_PARTNER_ID' );
        $this -> timestamp = $sigData['timestamp'];
        $this -> signature = $sigData['signature'];
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    public function verifyCustomer( array $data ) : mixed
    {
        $response = Http::withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json']) -> post( env( 'SMILE_PROD_URL' ),
        [
            'source_sdk' => 'rest_api',
            'source_sdk_version' => '1.0.0',
            'signature' => $this -> signature,
            'timestamp' => $this -> timestamp,

            'partner_params' => [ 'user_id' => generateAlphaNumericResource( 12 ), 'job_id' => generateAlphaNumericResource( 12 ), 'job_type' => 5 ],

            'country' => $data['country'],
            'id_type' => $data['id_type'],
            'id_number' => $data['id_number'],
            'partner_id' => $this -> partner_id,
        ]);

        return $response -> json();
    }

    /**
     * @param string $environment
     * @return array
     */
    public function generateSignature( string $environment = "sandbox" ) : array
    {
        $api_key = env('SMILE_ID_API_KEY');
        $partner_id = env('SMILE_ID_PARTNER_ID');
        $timestamp = now()->toISOString();
        $message = $timestamp . $partner_id . "sid_request";
        $signature = base64_encode(hash_hmac('sha256', $message, $api_key, true));

        return [
            'timestamp' => $timestamp,
            'signature' => $signature
        ];
    }
}
