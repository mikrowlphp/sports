<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('team_members')) {
            Schema::create('team_members', function (Blueprint $table) {
                $table->id();
                $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
                $table->foreignId('customer_id')->constrained('contacts')->cascadeOnDelete();
                $table->string('role');
                $table->integer('jersey_number')->nullable();
                $table->date('joined_at');
                $table->date('left_at')->nullable();
                $table->timestamps();

                // Indexes
                $table->index(['team_id', 'role']);
                $table->index('customer_id');
                $table->unique(['team_id', 'jersey_number']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
}
