<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->cascadeOnDelete();
            $table->string('code', 16);
            $table->string('name', 120);
            $table->string('slug', 140);
            $table->string('short_description', 255);
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['period_id', 'slug']);
            $table->unique(['period_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
