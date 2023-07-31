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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->timestamps();

            // Define foreign key constraint for platform_id referencing the platforms table.
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
