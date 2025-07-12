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
        Schema::create('residencies', function (Blueprint $table) {
            $table->id();
            $table->string('resident_name');
            $table->integer('resident_age');
            $table->string('voters_id_pre_number');
            $table->string('resident_email_address')->unique();
            $table->enum('civil_status', ['single', 'married']);
            $table->string('nationality')->default('Filipino');
            $table->text('address')->nullable();
            $table->boolean('has_criminal_record')->default(false);
            $table->text('resident_purpose')->nullable();
            $table->string('certificate_number')->unique();
            $table->string('zip_code')->nullable();
            $table->date('issue_date')->nullable();
            $table->string('approved_by')->default('0');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('approved')->default(0); // 0 = Not approved, 1 = Approved
            $table->string('barangay_name')->default('Panipuan');
            $table->string('municipality')->default('Sanfernando');
            $table->string('province')->default('Pampanga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residencies');
    }
};
