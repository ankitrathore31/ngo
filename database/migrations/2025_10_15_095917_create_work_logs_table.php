<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_logs', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type', 50)->nullable(); // 'staff' or 'ngo'
            $table->string('user_name', 255)->nullable();
            $table->string('user_code', 100)->nullable();
            $table->string('model_name', 100); // e.g. 'Member', 'Beneficiarie', 'Donation'
            $table->unsignedBigInteger('record_id')->nullable(); // e.g. ID of Member or Donation
            $table->date('work_date')->nullable();
            $table->string('title', 255)->nullable(); // short summary
            $table->text('description')->nullable(); // detailed info
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_logs');
    }
}
