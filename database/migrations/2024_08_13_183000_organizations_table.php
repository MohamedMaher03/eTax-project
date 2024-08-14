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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('commercial_register_number')->unsigned()->length(9);
            $table->string('tax_card_number');
            $table->integer('users_count');
            $table->integer('revisers_count');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('package_id')->constrained('packages');
            $table->integer('operations_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
