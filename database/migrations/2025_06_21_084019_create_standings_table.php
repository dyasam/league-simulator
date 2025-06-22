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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('simulation_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');

            $table->unsignedTinyInteger('played')->default(0);
            $table->unsignedTinyInteger('wins')->default(0);
            $table->unsignedTinyInteger('draws')->default(0);
            $table->unsignedTinyInteger('losses')->default(0);

            $table->unsignedTinyInteger('goals_for')->default(0);
            $table->unsignedTinyInteger('goals_against')->default(0);
            $table->integer('goal_difference')->default(0);
            $table->unsignedTinyInteger('points')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
