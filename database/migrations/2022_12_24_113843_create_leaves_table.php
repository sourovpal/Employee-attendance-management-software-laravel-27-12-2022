<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('attendance_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('description');
            $table->string('status')->default('0');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade');
            $table->foreign('attendance_id')->references('id')->on('attendances')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
