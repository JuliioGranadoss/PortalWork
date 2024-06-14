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
        Schema::table('workers', function (Blueprint $table) {
            $table->foreignId('job_id')->nullable()->after('user_id')->constrained('jobs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('jobboard_id')->nullable()->after('job_id')->constrained('job_boards')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropForeign(['jobboard_id']);
            $table->dropColumn(['job_id', 'jobboard_id']);
        });
    }
};
