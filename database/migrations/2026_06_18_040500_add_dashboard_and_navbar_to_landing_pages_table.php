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
        Schema::table('landing_pages', function (Blueprint $table) {
            // Navbar
            $table->json('navbar_links')->nullable()->after('hero_cta_secondary');
            $table->string('navbar_cta_text')->nullable()->after('navbar_links');
            $table->string('navbar_cta_url')->nullable()->after('navbar_cta_text');

            // Dashboard
            $table->string('dashboard_title')->nullable()->after('about_image');
            $table->text('dashboard_description')->nullable()->after('dashboard_title');
            $table->string('dashboard_image')->nullable()->after('dashboard_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'navbar_links',
                'navbar_cta_text',
                'navbar_cta_url',
                'dashboard_title',
                'dashboard_description',
                'dashboard_image',
            ]);
        });
    }
};
