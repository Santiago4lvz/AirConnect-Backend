<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iot', function (Blueprint $table) {
            $table->id();
            $table->string('device_name');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->string('location')->nullable();
            // $table->string('ip_address')->nullable();
            $table->double('co2_level', 10, 2)->nullable();
            $table->double('temperature', 10, 2)->nullable();
            $table->double('humidity', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iot');
    }
};
