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
        Schema::create('caja_salon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->nullable();
            $table->timestamp('fecha')->nullable();
            $table->double('monto')->nullable();
            $table->foreignId('admin_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_salon');
    }
};
