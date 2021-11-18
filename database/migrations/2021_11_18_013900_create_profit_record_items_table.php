<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitRecordItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profit_record_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profit_record_id');
            $table->foreign('profit_record_id')->references('id')->on('profit_records');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('profit_id')->nullable();
            $table->foreign('profit_id')->references('id')->on('profits');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->float('value')->default(0);
            $table->timestamp('date');
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profit_record_items');
    }
}
