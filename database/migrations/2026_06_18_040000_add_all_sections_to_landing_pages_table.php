<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            // Hero extras
            $table->string('hero_badge')->nullable()->after('hero_image');
            $table->string('hero_cta_primary')->nullable()->after('hero_badge');
            $table->string('hero_cta_secondary')->nullable()->after('hero_cta_primary');

            // CTA section
            $table->string('cta_title')->nullable()->after('about_image');
            $table->text('cta_description')->nullable()->after('cta_title');

            // JSON sections
            $table->json('benefits')->nullable()->after('cta_description');
            $table->json('steps')->nullable()->after('benefits');
            $table->json('testimonials')->nullable()->after('steps');
            $table->json('pricing_plans')->nullable()->after('testimonials');
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'hero_badge',
                'hero_cta_primary',
                'hero_cta_secondary',
                'cta_title',
                'cta_description',
                'benefits',
                'steps',
                'testimonials',
                'pricing_plans',
            ]);
        });
    }
};
