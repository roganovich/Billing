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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->integer('type_id')->default(1);
            $table->integer('status_id')->default(1);
            $table->decimal('amount', $precision = 8, $scale = 2)->default(0);
            $table->decimal('balance', $precision = 8, $scale = 2)->default(0);
            $table->json('options');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
};
