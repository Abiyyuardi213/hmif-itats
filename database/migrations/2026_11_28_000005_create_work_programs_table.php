<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('division_id')->constrained()->cascadeOnDelete();
            $table->string('title', 160);
            $table->string('slug', 180);
            $table->text('description');
            $table->string('status', 24)->default('planned')->index();
            $table->date('target_date')->nullable();
            $table->date('realized_at')->nullable();
            $table->unsignedInteger('target_participants')->nullable();
            $table->timestamps();

            $table->unique(['period_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_programs');
    }
};
