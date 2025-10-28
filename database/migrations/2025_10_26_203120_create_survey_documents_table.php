<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_benefries_id')->constrained('survey_benefries')->onDelete('cascade');
            $table->boolean('aadhar_guardian')->default(false);
            $table->boolean('account_no_guardian')->default(false);
            $table->boolean('aay_jati_nivas_guardian')->default(false);
            $table->boolean('adhyan_pramn_patr_guardian')->default(false);
            $table->boolean('ration_card_guardian')->default(false);
            $table->boolean('color_photo_guardian')->default(false);
            $table->boolean('mobile_aadhar_link_guardian')->default(false);
            $table->boolean('signature_thumb_guardian')->default(false);
            $table->boolean('aay_jati_nivas_beneficiary')->default(false);
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('survey_documents');
    }
}
