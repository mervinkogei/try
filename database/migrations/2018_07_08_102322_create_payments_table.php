<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration{
    public function up(){
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user');
            $table->string('receiptno');
            $table->string('credit');
            $table->string('debit');
            $table->string('description')->nullable();
            $table->string('paidfor')->nullable();
            $table->timestamps();
        });
    }


    public function down(){
        Schema::dropIfExists('payments');
    }
}
