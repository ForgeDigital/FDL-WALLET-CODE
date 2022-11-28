<?php

namespace App\Models\Customer\Resource\Customer;

use App\Models\Customer\Resource\IDData\IDData;
use App\Models\Customer\Resource\Wallet\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [ 'id' ];

    /**
     * @return string
     */
    public function getRouteKeyName () : string { return 'resource_id'; }

    /**
     * @return BelongsTo
     */
    public function id_data(): BelongsTo
    {
        return $this -> belongsTo( IDData::class );
    }

    /**
     * @return HasMany
     */
    public function wallets() : HasMany
    {
        return $this -> hasMany( Wallet::class );
    }
}
