<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonorDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donor_datas', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name', 150);    
            $table->string('donor_email', 191);       
            $table->string('donor_number', 20);       
            $table->string('donor_country', 100)->nullable();
            $table->string('donor_state', 100)->nullable();
            $table->string('donor_district', 100)->nullable();
            $table->string('donor_post', 100)->nullable();
            $table->string('donor_pincode', 10)->nullable();    
            $table->string('donor_village', 150)->nullable();
            $table->string('donor_idtype', 50)->nullable();     
            $table->string('donor_aadhar', 20)->nullable();     
            $table->string('donor_pancard', 15)->nullable();    
            $table->string('donation_category', 100)->nullable(); 
            $table->text('donation_remark')->nullable();
            $table->decimal('donation_amount', 10, 2);
            $table->date('donate_date')->nullable();
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
        Schema::dropIfExists('donor_datas');
    }
}
