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
                $table->string('role')->default('cliente'); // cliente|gestor
                $table->date('birthdate')->nullable();      // paciente
                $table->string('crm')->nullable();          // médico (registro profissional)
                $table->string('phone')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role','birthdate','crm','phone']);
        });
    }
};
