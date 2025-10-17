<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyBenefriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_benefries', function (Blueprint $table) {
            $table->id();
            // Project details
            $table->string('project_code');
            $table->string('project_name');
            $table->string('center');
            $table->string('state');
            $table->string('district');
            $table->string('animator_code');
            $table->string('animator_name');
            $table->date('session');
            $table->date('date');

            // Beneficiary details
            $table->string('name');
            $table->string('father_husband_name');
            $table->text('address');
            $table->string('mobile_no');
            $table->string('caste')->nullable();
            $table->integer('age');
            $table->string('beneficiaries_type');
            $table->integer('disability_percentage')->nullable();
            $table->string('widow_since')->nullable();
            $table->string('type_of_victim')->nullable();
            $table->string('class')->nullable();
            $table->text('place_identification_mark')->nullable();

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
        Schema::dropIfExists('survey_benefries');
    }
}
