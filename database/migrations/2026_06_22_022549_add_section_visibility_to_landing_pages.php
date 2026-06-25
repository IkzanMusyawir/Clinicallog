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
            $table->boolean('about_visible')->default(true)->after('about_description');
            $table->boolean('features_visible')->default(true)->after('about_visible');
            $table->boolean('benefits_visible')->default(true)->after('benefits');
            $table->boolean('dashboard_visible')->default(true)->after('dashboard_description');
            $table->boolean('steps_visible')->default(true)->after('steps');
            $table->boolean('pricing_visible')->default(true)->after('pricing_plans');
            $table->boolean('cta_visible')->default(true)->after('cta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'about_visible',
                'features_visible',
                'benefits_visible',
                'dashboard_visible',
                'steps_visible',
                'pricing_visible',
                'cta_visible'
            ]);
        });
    }
};
