<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseChoicesTable extends Migration
{
    public function up()
    {
        Schema::create('response_choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_id');
            $table->unsignedBigInteger('choice_id');
            $table->timestamps();

            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');
            $table->foreign('choice_id')->references('id')->on('choices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('response_choices');
    }
}
