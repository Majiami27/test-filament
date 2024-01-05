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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('mac_address', 30)->index();
            $table->string('name', 30);
            $table->string('custom_id', 30);
            $table->foreignId('area_id', 30)->nullable();
            $table->string('ip', 30);
            $table->string('ssid', 32);
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('organization_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
