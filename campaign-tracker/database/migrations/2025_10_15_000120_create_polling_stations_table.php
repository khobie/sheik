<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('polling_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electoral_area_id')->constrained('electoral_areas')->cascadeOnDelete();
            $table->string('station_code', 15)->unique();
            $table->string('station_name', 150);
            $table->string('location', 150)->nullable();
            $table->string('agent_name', 120)->nullable();
            $table->string('agent_phone', 20)->nullable();
            $table->unsignedInteger('voter_population')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('polling_stations'); }
};