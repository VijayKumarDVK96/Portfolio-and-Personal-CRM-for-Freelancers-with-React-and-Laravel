<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. AWS Certified Developer
            $table->string('organization'); // e.g. Amazon Web Services, Meta, Google Cloud
            $table->year('year'); // e.g. 2023, 2022
            $table->text('description')->nullable(); // optional details
            $table->string('image')->nullable(); // optional

            // Foreign key
            $table->unsignedBigInteger('category_id');
            $table->string('credentials')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('certifications_categories')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
