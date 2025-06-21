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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('comment_id');
            $table->text('content');
            $table->enum('target_type', ['blog', 'product']);
            $table->softDeletes();

            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('blog_id')->constrained('blog', 'blog_id')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('product', 'product_id')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments', 'comment_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
