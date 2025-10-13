<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_translations', function (Blueprint $table) {
            $table->id();

            // Link to main promotions table
            $table->foreignId('promotion_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Locale code (e.g. 'en', 'zh', 'ms')
            $table->string('locale', 10);

            // Translatable content
            $table->string('title');
            $table->string('short_description')->nullable();

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();

            // Each promotion can have only one translation per locale
            $table->unique(['promotion_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_translations');
    }
};
