<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->string('category', 64)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->string('excerpt', 320);
            $table->text('content');
            $table->string('attachment_path')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
