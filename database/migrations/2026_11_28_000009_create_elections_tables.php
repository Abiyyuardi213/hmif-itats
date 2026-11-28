<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->cascadeOnDelete();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->text('description')->nullable();
            $table->string('status', 24)->default('draft')->index();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->timestamps();
        });

        Schema::create('election_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('candidate_number');
            $table->string('ketua_name', 120);
            $table->string('wakil_name', 120)->nullable();
            $table->string('tagline', 200)->nullable();
            $table->text('vision_mission');
            $table->string('photo_path')->nullable();
            $table->timestamps();

            $table->unique(['election_id', 'candidate_number']);
        });

        Schema::create('eligible_voters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->string('identifier_hash', 64);
            $table->string('identifier_masked', 40);
            $table->string('voter_name', 120);
            $table->string('voter_type', 24)->default('mahasiswa');
            $table->string('email', 160);
            $table->boolean('has_voted')->default(false)->index();
            $table->timestamp('voted_at')->nullable();
            $table->timestamps();

            $table->unique(['election_id', 'identifier_hash']);
            $table->unique(['election_id', 'email']);
        });

        Schema::create('voter_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->foreignId('eligible_voter_id')->constrained()->cascadeOnDelete();
            $table->string('token_hash', 64)->unique();
            $table->timestamp('expires_at')->index();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });

        // Anonymous ballot table: intentionally contains NO voter/user/email/IP identifiers.
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained('election_candidates')->cascadeOnDelete();
            $table->string('receipt_hash', 64)->unique();
            $table->timestamp('cast_at');
            $table->timestamps();

            $table->index(['election_id', 'candidate_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
        Schema::dropIfExists('voter_tokens');
        Schema::dropIfExists('eligible_voters');
        Schema::dropIfExists('election_candidates');
        Schema::dropIfExists('elections');
    }
};
