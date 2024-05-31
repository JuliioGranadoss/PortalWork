<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'entry_number'
     * entry_date
     */
    public function up(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->string('entry_number')->unique()->nullable()->after('jobboard_id');
            $table->dateTime('entry_date')->nullable()->after('entry_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropColumn('entry_date');
            $table->dropColumn('entry_number');
        });
    }
};
