<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // BASIC
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('lrn')->unique();

            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->date('birthdate')->nullable();

            // ADDRESS
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();

            // SCHOOL
            $table->string('elementary_school')->nullable();
            $table->string('last_school')->nullable();

            // PARENTS
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();

            // ASSIGNMENT
            $table->string('grade_level')->nullable();
            $table->string('strand')->nullable();
            $table->string('section')->nullable();

            // FILES
            $table->string('psa')->nullable();
            $table->string('form137')->nullable();
            $table->string('form138')->nullable();
            $table->string('good_moral')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}