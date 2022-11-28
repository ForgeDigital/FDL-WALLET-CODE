<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('customers', function ( Blueprint $table )
        {
            $table -> id();
            $table -> string( 'resource_id' ) -> unique() -> nullable( false );

            $table -> string('first_name' ) -> nullable( false );
            $table -> string('middle_name' ) -> nullable( false );
            $table -> string('last_name' ) -> nullable( false );

            $table -> string('dob' ) -> nullable();
            $table -> string('gender' ) -> nullable();

            $table -> string('country' ) -> nullable();
            $table -> string('address' ) -> nullable();
            $table -> string('primary_phone' ) -> nullable();
            $table -> string('secondary_phone' ) -> nullable();

            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('customers');
    }
};
