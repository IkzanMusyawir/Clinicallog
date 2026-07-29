<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'social_linkedin',
                'social_instagram',
                'social_youtube',
            ]);
            $table->json('social_links')->nullable()->after('footer_description');
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('social_linkedin')->nullable()->after('footer_description');
            $table->string('social_instagram')->nullable()->after('social_linkedin');
            $table->string('social_youtube')->nullable()->after('social_instagram');
            $table->dropColumn('social_links');
        });
    }
};
