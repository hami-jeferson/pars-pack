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
        Schema::create('expired_subscriptions', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('app_id');
            $table->integer('expired_count')->unsigned();
            $table->date('sync_date');
            $table->timestamps();

            //$table->foreign('app_id')->references('id')->on('apps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expired_subscriptions');
    }
};
