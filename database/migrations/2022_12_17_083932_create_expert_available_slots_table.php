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
        Schema::create('expert_available_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expert_id');
            //$table->unsignedBigInteger('expert_available_time_id');
            $table->time('from');
            $table->time('to');
            $table->tinyInteger('is_deleted')->default(0)->comment('0=>active,1=>inactive');
            $table->foreign('expert_id')->references('id')->on('users');
            //$table->foreign('expert_available_time_id')->references('id')->on('expert_available_times');
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
        Schema::dropIfExists('expert_available_slots');
    }
};
