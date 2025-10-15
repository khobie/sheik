<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->unique()->after('name');
            $table->string('phone', 20)->nullable()->after('email');
            $table->enum('role', ['ADMIN','ZONAL_COORDINATOR','AREA_COORDINATOR','POLLING_AGENT'])->default('POLLING_AGENT')->after('phone');
            $table->foreignId('zone_id')->nullable()->after('role')->constrained('zones')->nullOnDelete();
            $table->enum('status', ['active','inactive'])->default('active')->after('zone_id');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('zone_id');
            $table->dropColumn(['username','phone','role','status']);
        });
    }
};