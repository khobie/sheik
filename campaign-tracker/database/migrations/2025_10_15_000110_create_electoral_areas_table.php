<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('electoral_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->string('area_name', 100);
            $table->string('area_code', 10)->unique();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('electoral_areas'); }
};