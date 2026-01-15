<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorContractsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('sponsor_contracts')) {
            Schema::create('sponsor_contracts', function (Blueprint $table) {
                $table->id();

                // Foreign key to sponsors table
                $table->foreignId('sponsor_id')
                    ->constrained('sponsors')
                    ->cascadeOnDelete();

                // Contract period
                $table->date('start_date');
                $table->date('end_date');

                // View limitations
                $table->integer('max_views')->nullable()->comment('Maximum views allowed - null means unlimited');
                $table->integer('used_views')->default(0)->comment('Current view count');

                // Contract status
                $table->boolean('is_active')->default(true);

                // Additional information
                $table->text('notes')->nullable();

                $table->timestamps();

                // Indexes for performance
                $table->index('sponsor_id');
                $table->index('is_active');
                $table->index(['start_date', 'end_date']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_contracts');
    }
}
