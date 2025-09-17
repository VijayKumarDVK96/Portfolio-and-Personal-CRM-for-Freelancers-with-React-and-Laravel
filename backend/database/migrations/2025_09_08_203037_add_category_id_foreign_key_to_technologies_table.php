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
        Schema::table('technologies', function (Blueprint $table) {
            // Add column if it doesn't exist
            if (!Schema::hasColumn('technologies', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('id');
                $table->string('logo')->nullable();
            }

            // Add foreign key with cascade delete
            $table->foreign('category_id')
                ->references('id')
                ->on('technologies_categories')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('technologies', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
