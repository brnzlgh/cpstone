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
    Schema::create('enrollees', function (Blueprint $table) {
        $table->id();

        // PERSONAL INFO
        $table->string('lrn')->nullable();
        $table->string('last_name');
        $table->string('first_name');
        $table->string('middle_name')->nullable();
        $table->string('gender')->nullable(); // ✅ FIX (avoid crash if empty)
        $table->date('birthdate')->nullable();
        $table->string('place_of_birth')->nullable();
        $table->string('nationality')->nullable();

        // ADDRESS / SCHOOL
        $table->string('province')->nullable();
        $table->string('city')->nullable();
        $table->string('elementary_school')->nullable();
        $table->string('year_graduated')->nullable();
        $table->string('last_school')->nullable();
        $table->string('street')->nullable();
        $table->string('barangay')->nullable();
        $table->string('region')->nullable();

        // CONTACT
        $table->string('email')->nullable(); // ✅ FIX (avoid required error)
        $table->string('mobile')->nullable(); // ✅ FIX
        $table->string('telephone')->nullable();

        // PARENTS
        $table->string('father_name')->nullable();
        $table->string('mother_name')->nullable();
        $table->string('parent_address')->nullable();
        $table->string('father_contact')->nullable();
        $table->string('mother_contact')->nullable();

        // GUARDIAN
        $table->boolean('use_guardian')->default(false);
        $table->string('guardian_name')->nullable();
        $table->string('guardian_address')->nullable();
        $table->string('guardian_contact')->nullable();

        // ACADEMIC
        $table->string('grade_level')->nullable(); // ✅ FIX
        $table->string('strand')->nullable(); // ✅ FIX

        // STATUS
        $table->enum('status', ['pending', 'approved', 'archived'])->default('pending');

        $table->timestamps();
        $table->string('psa')->nullable();
        $table->string('form137')->nullable();
        $table->string('form138')->nullable();
        $table->string('good_moral')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollees');
    }
};