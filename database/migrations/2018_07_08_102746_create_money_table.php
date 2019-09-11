<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyTable extends Migration{
    public function up(){
        Schema::create('money', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('value');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('money');
    }
}
