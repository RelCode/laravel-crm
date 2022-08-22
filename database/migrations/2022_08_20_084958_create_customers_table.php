<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->string('name',255);
            $table->string('profession',255);
            $table->string('email',255);
            $table->string('phone',32)->nullable();
            $table->string('address',128)->nullable();
            $table->foreignId('city')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('province')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('customers');
    }
}
