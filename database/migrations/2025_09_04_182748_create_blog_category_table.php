<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->primary(['blog_id','category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_category');
    }
};
