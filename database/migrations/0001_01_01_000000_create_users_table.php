<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id_role');
            $table->string('nom_role')->unique();
            $table->string('description')->nullable();
        });

        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->increments('id_utilisateur');
            $table->unsignedInteger('id_employe')->nullable();
            $table->string('username')->unique();
            $table->string('mot_de_passe');
            $table->string('email')->nullable()->unique();
            $table->timestamp('date_creation')->nullable();
            $table->timestamp('date_modification')->nullable();
        });

        Schema::create('utilisateurs_roles', function (Blueprint $table) {
            $table->unsignedInteger('id_utilisateur');
            $table->unsignedInteger('id_role');
            $table->primary(['id_utilisateur', 'id_role']);
            $table->foreign('id_utilisateur')->references('id_utilisateur')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('id_role')->references('id_role')->on('roles')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs_roles');
        Schema::dropIfExists('utilisateurs');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
