<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManageAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('peran')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();  // Gunakan unsignedBigInteger untuk foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Definisikan relasi foreign key
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
        Schema::dropIfExists('manage_accesses');
    }
}
