<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGbsBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gbs_bills', function (Blueprint $table) {
            $table->id();
            $table->string('academic_session')->nullable();
            $table->string('ngo_id')->nullable();
            $table->date('bill_date');
            $table->string('name');
            $table->string('guardian_name');
            $table->string('village')->nullable();
            $table->string('post');
            $table->string('block');
            $table->string('state');
            $table->string('district');
            $table->string('branch');
            $table->string('centre');
            $table->date('date'); // This appears twice in your form; keep only one if it's the same
            $table->text('work');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            // Cheque-specific fields
            $table->string('cheque_no')->nullable();
            $table->string('tr_bank_name')->nullable();
            $table->string('tr_bank_branch')->nullable();
            $table->date('cheque_date')->nullable();
            // UPI-specific fields
            $table->string('transaction_no')->nullable();
            $table->date('transaction_date')->nullable();
            // Bank details
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->text('place');
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
        Schema::dropIfExists('gbs_bills');
    }
}
