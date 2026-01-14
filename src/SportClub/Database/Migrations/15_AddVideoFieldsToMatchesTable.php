<?php

namespace Packages\Sports\SportClub\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoFieldsToMatchesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('matches') && !Schema::hasColumn('matches', 'video_url')) {
            Schema::table('matches', function (Blueprint $table) {
                $table->string('video_url')->nullable()->comment('URL to .m3u8 video file');
                $table->boolean('recording_enabled')->default(false)->comment('Enable match recording');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('matches')) {
            Schema::table('matches', function (Blueprint $table) {
                if (Schema::hasColumn('matches', 'video_url')) {
                    $table->dropColumn('video_url');
                }
                if (Schema::hasColumn('matches', 'recording_enabled')) {
                    $table->dropColumn('recording_enabled');
                }
            });
        }
    }
}
