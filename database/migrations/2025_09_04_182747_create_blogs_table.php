<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id(); // BIGINT UNSIGNED
            $table->string('title');
            $table->longText('description');
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('publish_at');
            $table->unsignedInteger('time_to_read')->default(5);
            $table->enum('status', ['draft','private','published'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
