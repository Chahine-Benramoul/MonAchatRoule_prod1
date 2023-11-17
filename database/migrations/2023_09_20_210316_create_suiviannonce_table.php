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
        Schema::create('suiviannonces', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger("userid");
            $table->foreign("userid")->references("id")->on("users");

            $table->unsignedBigInteger("publication_id")->nullable();
            $table->foreign("publication_id")->references("id")->on("publications");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suiviannonces');
    }
};
