<?php

namespace App\Models\Customer\Resource\IDData;

use App\Models\Customer\Resource\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IDData extends Model
{
    use HasFactory;

    protected $guarded = [ 'id' ], $table = 'id_data';

    /**
     * @return string
     */
    public function getRouteKeyName () : string { return 'resource_id'; }

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this -> belongsTo( Customer::class );
    }
}
