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
        Schema::create('prototype', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('modelpro_id')->constrained('modelpro')->onDelete('cascade');
            $table->string('name');
            $table->float('temperature');
            $table->float('humidity');
            $table->float('dust_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prototype', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['modelpro_id']);
        });

        Schema::dropIfExists('prototype');
        
    }
};
