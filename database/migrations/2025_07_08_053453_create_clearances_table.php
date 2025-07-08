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
        Schema::create('clearances', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->date('birthdate');
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated'])->nullable();
            $table->string('citizenship')->nullable();
            $table->string('occupation')->nullable();
            $table->string('contact')->nullable();
            $table->string('house_no')->nullable();
            $table->string('purok')->nullable();
            $table->string('barangay')->default('Panipuan');
            $table->string('municipality')->default('San Fernando');
            $table->string('province')->default('Pampanga');
            $table->text('purpose');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clearances');
    }
};
