<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('fields')) {
            Schema::create('fields', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sport_id')
                    ->constrained('sports')
                    ->onDelete('cascade');
                $table->string('name', 100);
                $table->text('description')->nullable();
                $table->integer('capacity')->nullable();
                $table->decimal('hourly_rate', 10, 2)->nullable();
                $table->string('color', 7)->nullable(); // hex color #RRGGBB
                $table->boolean('is_indoor')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();

                // Indexes
                $table->index(['sport_id', 'is_active']);
                $table->index(['is_active', 'sort_order']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
}
