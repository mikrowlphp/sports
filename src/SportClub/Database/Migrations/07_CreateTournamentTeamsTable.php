<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentTeamsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('tournament_teams')) {
            Schema::create('tournament_teams', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
                $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
                $table->integer('seed')->nullable();
                $table->string('status')->default('registered');
                $table->datetime('registration_date');
                $table->timestamps();

                // Indexes
                $table->index(['tournament_id', 'status']);
                $table->unique(['tournament_id', 'team_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_teams');
    }
}
