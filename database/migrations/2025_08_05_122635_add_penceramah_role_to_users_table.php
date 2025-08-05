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
        Schema::table('users', function (Blueprint $table) {
            // Update enum role to include 'penceramah'
            $table->dropColumn('role');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'penceramah'])->default('admin')->after('username');
            $table->unsignedBigInteger('id_penceramah')->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'id_penceramah']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin'])->default('admin')->after('username');
        });
    }
};
