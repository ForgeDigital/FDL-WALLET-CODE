<?php

namespace App\Http\Requests\Customer\Resource\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CustomerRequest extends FormRequest
{
    /**
     * @param Validator $validator
     */
    protected function failedValidation( Validator $validator )
    {
        throw new HttpResponseException( response() -> json([ 'status' => 'Error', 'code' => Response::HTTP_UNPROCESSABLE_ENTITY, 'errors' => $validator -> errors() -> all() ]));
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        if ( in_array( $this -> getMethod (), [ 'PUT', 'PATCH' ] ) )
        {
            return $rules =
            [
                'data'                                                                  => [ 'required' ],
                'data.type'                                                             => [ 'required', 'string', 'in:Customer' ],
            ];
        }
        return
        [
            'data'                                                                      => [ 'required' ],
            'data.type'                                                                 => [ 'required', 'string', 'in:Customer' ],

            'data.attributes.resource_id'                                               => [ 'required', 'string' ],
            'data.attributes.id_type'                                                   => [ 'required', 'string' ],
            'data.attributes.id_number'                                                 => [ 'required', 'string' ],

//            'data.relationships.country.type'                                           => [ 'required', 'string', 'in:Country' ],
//            'data.relationships.country.attributes.resource_id'                         => [ 'required', 'exists:countries,resource_id' ],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return
        [
            'data.required'                                                             => "The data field is invalid",

            'data.type.required'                                                        => "The type is required",
            'data.type.string'                                                          => "The type must be of a string",
            'data.type.in'                                                              => "The type is invalid",

            'data.attributes.first_name.required'                                       => "The first name is required",
            'data.attributes.first_name.string'                                         => "The first name must be of a string type",

            'data.attributes.last_name.required'                                        => "The last name is required",
            'data.attributes.last_name.string'                                          => "The last name must be of a string type",

            'data.relationships.country.type.required'                                  => "The country type is required",
            'data.relationships.country.type.string'                                    => "The country type must be of a string",
            'data.relationships.country.type'                                           => "The country type is invalid",
            'data.relationships.country.attributes.resource_id.required'                => "The country is required",
            'data.relationships.country.attributes.resource_id.exists'                  => "The country does not exist",
        ];
    }
}
