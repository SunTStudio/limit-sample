<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_part_id')->constrained()->onDelete('cascade');
            $table->foreignId('part_id')->constrained()->onDelete('cascade');
            $table->foreignId('part_area_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('part_number');
            $table->string('document_number');
            $table->string('characteristics');
            $table->date('effective_date');
            $table->date('expired_date');
            $table->text('deskripsi');
            $table->string('dimension');
            $table->string('appearance');
            $table->string('jumlah');
            $table->text('metode_pengecekan');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('penolakan')->nullable();
            $table->date('penocolumn: lakan_date')->nullable();
            $table->string('status');
            $table->string('foto_ke_satu')->nullable();
            $table->string('foto_ke_dua')->nullable();
            $table->string('foto_ke_tiga')->nullable();
            $table->string('foto_ke_empat')->nullable();
            $table->string('sec_head_approval_date')->nullable();
            $table->string('dept_head_approval_date')->nullable();
            $table->date('submit_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('area_parts');
    }
}
