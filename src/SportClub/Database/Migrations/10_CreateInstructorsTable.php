<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('instructors')) {
            Schema::create('instructors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained('contacts')->cascadeOnDelete();
                $table->json('specializations');
                $table->text('bio')->nullable();
                $table->decimal('hourly_rate', 10, 2);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                // Indexes
                $table->index('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
}
