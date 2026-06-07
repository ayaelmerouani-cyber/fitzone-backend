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
            $table->string('abonnement')->default('Mensuel'); // نوع الاشتراك
            $table->string('statut')->default('Actif'); // حالة الدفع
            $table->boolean('certificat')->default(false); // واش جاب الشهادة الطبية (0 = لا، 1 = آه)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
