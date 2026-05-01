<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('enrollees', function (Blueprint $table) {

        $table->string('elem_completion')->nullable();
        $table->string('elem_address')->nullable();
        $table->string('elem_region')->nullable();

        $table->string('house_no')->nullable();
        $table->string('street_name')->nullable();
        $table->string('barangay_last')->nullable();
        $table->string('town_city')->nullable();
        $table->string('province_last')->nullable();
        $table->string('region_last')->nullable();
        $table->string('completion_year')->nullable();
        $table->string('school_email')->nullable();

        $table->string('emergency_name')->nullable();
        $table->string('emergency_contact')->nullable();
        $table->string('emergency_address')->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollees', function (Blueprint $table) {
            //
        });
    }
};
