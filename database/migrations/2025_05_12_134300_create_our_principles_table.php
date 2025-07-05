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
        Schema::create('our_principles', function (Blueprint $table) {
            $table->id('principle_id');
            $table->string('subtitle');
            $table->string('name');
            $table->string('thumbnail');
            $table->string('icon');
            $table->foreignId('created_by')->constrained('users', 'user_id')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_principles');
    }
};
