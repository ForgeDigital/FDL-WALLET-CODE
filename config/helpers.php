<?php

use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @return array
 * @throws ContainerExceptionInterface
 * @throws NotFoundExceptionInterface
 */
function includeResources() : array
{
    return ( request() -> get( 'include' ) ) ? explode( ',', request() -> get( 'include' ) ) : [];
}

/**
 * @param bool $is_related
 * @return void
 */
function checkResourceRelation( bool $is_related ) : void
{
    abort_unless( $is_related, response() -> json([ 'status' => 'Error', 'code' => Response::HTTP_CONFLICT, 'message' => 'The resource you are trying to access does not belong to this category', 'data' => null ]));
}

/**
 * Generate unique ID
 * @param int $length
 * @param $table
 * @return string
 */
function generateResource( int $length, $table ) : string
{
    $number = '';
    do { for ( $i = $length; $i --; $i > 0 ) { $number .= mt_rand(0,9); } }
    while ( !empty( DB::table( $table ) -> where( 'resource_id', $number ) -> first([ 'resource_id' ])) );

    return $number;
}

/**
 * Generate unique ID
 * @return string
 */
function generateAlphaNumericResource( $length ) : string
{
    $token = "";

    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";

    $max = strlen( $codeAlphabet );

    for ( $i=0; $i < $length; $i++ )
    {
        $token .= $codeAlphabet[crypto_rand_secure( 0, $max-1 )];
    }

    return $token;
}

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;

    if ( $range < 1 ) return $min;

    $log = ceil( log( $range, 2 ));
    $bytes = ( int ) ( $log / 8 ) + 1;
    $bits = ( int ) $log + 1;
    $filter = ( int ) ( 1 << $bits ) - 1;

    do
    {
        $rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes )));
        $rnd = $rnd & $filter;
    }
    while ( $rnd > $range );

    return $min + $rnd;
}
