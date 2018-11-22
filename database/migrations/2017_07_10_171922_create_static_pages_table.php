<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages', function (Blueprint $table) {
          $table->increments('id');
          $table->string('identifier')->unique();
          $table->string('es_title')->nullable();
          $table->string('en_title')->nullable();
          $table->text('es_description')->nullable();
          $table->text('en_description')->nullable();
          $table->text('es_keywords')->nullable();
          $table->text('en_keywords')->nullable();
          $table->string('url');
          $table->tinyInteger('bilingual')->default(0);
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
        Schema::dropIfExists('static_pages');
    }
}
