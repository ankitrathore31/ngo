<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
             $table->string('academic_session')->nullable();
            $table->string('ngo_id')->nullable();
            $table->string('problem_no');
            $table->date('problem_date');
            $table->string('address');
            $table->string('block');
            $table->string('state');
            $table->string('district');
            $table->text('description');
            $table->string('problem_by');
            $table->text('problem_solution')->nullable();
            $table->date('solution_date')->nullable();
            $table->string('solution_by')->nullable();
            $table->text('solution_description')->nullable();
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
        Schema::dropIfExists('problems');
    }
}
