<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->unsignedInteger('category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->tinyInteger('featured')->default(0);
            $table->enum('type', ['photo', 'video', 'widget'])->default('photo');
            $table->string('extension', 4);
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
        Schema::dropIfExists('gallery_contents');
    }
}
