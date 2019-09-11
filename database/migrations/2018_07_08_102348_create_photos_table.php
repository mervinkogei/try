<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration{
    public function up(){
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('native');
            $table->string('nativeid');
            $table->string('dimension')->nullable();
            $table->string('info')->nullable();
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('photos');
    }
}
