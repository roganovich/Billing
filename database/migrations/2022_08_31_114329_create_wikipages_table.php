<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wikipages', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable(); ;
            $table->string('title');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->string('header')->nullable();
            $table->longText('preview')->nullable();
            $table->string('thumb')->nullable();
            $table->longText('seo_description')->nullable();
            $table->longText('seo_keywords')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wikipages');
    }
};
