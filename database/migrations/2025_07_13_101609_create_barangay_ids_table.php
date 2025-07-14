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
        Schema::create('barangay_ids', function (Blueprint $table) {
            $table->id();
            $table->string('barangayId_image')->nullable();
            $table->string('barangayId_full_name');
            $table->string('barangayId_email')->unique();
            $table->string('barangayId_address');
            $table->date('barangayId_birthdate');
            $table->string('barangayId_place_of_birth')->nullable();
            $table->integer('barangayId_age')->nullable();
            $table->string('barangayId_citizenship')->nullable();
            $table->enum('barangayId_gender', ['male', 'female', 'other'])->nullable();
            $table->string('barangayId_civil_status')->nullable();
            $table->string('barangayId_contact_no')->nullable();
            $table->string('barangayId_guardian')->nullable();
            $table->string('barangayId_generated_number')->unique();

            $table->string('approved_by')->default('0');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('approved')->default(0); // 0 = Not approved, 1 = Approved
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay_ids');
    }
};
