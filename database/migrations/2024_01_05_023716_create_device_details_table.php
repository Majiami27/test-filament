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
        Schema::create('device_details', function (Blueprint $table) {
            $table->id();
            $table->string('mac_address');
            $table->unsignedTinyInteger('port');
            $table->string('port_name', 30);
            $table->unsignedTinyInteger('status');
            $table->timestamps();

            $table->unique(['mac_address', 'port']);
            $table->index('mac_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_details');
    }
};
