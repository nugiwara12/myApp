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
        Schema::create('indigencies', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name');
            $table->string('indigency_email')->unique();
            $table->string('address');
            $table->string('purpose');
            $table->string('childs_name');
            $table->unsignedTinyInteger('age');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('approved')->default(0); // 0 = Not approved, 1 = Approved
            $table->string('approved_by')->default('0');
            $table->string('indigency_generated_number');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indigencies');
    }
};
