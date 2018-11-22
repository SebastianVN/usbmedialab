<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_contents', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('box_id')->nullable();
          $table->string('identifier');
          $table->string('lang', 5);
          $table->string('descripcion')->nullable();
          $table->text('content');
          $table->enum('content_type', ['formatted_text', 'long_text', 'short_text', 'image'])->default('formatted_text');
          $table->integer('box_order')->nullable();
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
        Schema::dropIfExists('static_contents');
    }
}
