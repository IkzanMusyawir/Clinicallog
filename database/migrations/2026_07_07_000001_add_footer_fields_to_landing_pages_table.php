<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->text('footer_description')->nullable()->after('privacy_gdrive_url');
            $table->string('social_linkedin')->nullable()->after('footer_description');
            $table->string('social_instagram')->nullable()->after('social_linkedin');
            $table->string('social_youtube')->nullable()->after('social_instagram');
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'footer_description',
                'social_linkedin',
                'social_instagram',
                'social_youtube',
            ]);
        });
    }
};
