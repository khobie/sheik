<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('polling_station_id')->constrained('polling_stations');
            $table->enum('support_level', ['KEN','BAWUMIA','DR_ADU_TWU','UNDECIDED','OTHER']);
            $table->unsignedInteger('supporters_count')->default(0);
            $table->text('key_issues')->nullable();
            $table->text('specific_concerns')->nullable();
            $table->boolean('follow_up_required')->default(false);
            $table->string('follow_up_action')->nullable();
            $table->text('survey_notes')->nullable();
            $table->date('survey_date');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('surveys'); }
};