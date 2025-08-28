<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->id();
            $table->string('academic_session')->nullable();
            $table->string('ngo_id')->nullable();
            $table->unsignedBigInteger('transaction_id'); // FK -> salary_transactions
            $table->unsignedBigInteger('staff_id');       // FK -> staff (optional, for quick filtering)
            $table->decimal('amount', 10, 2);             // payment amount
            $table->date('payment_date');                 // when paid
            $table->enum('payment_mode', ['cash', 'bank', 'cheque', 'upi']);

            // optional details
            $table->string('bank_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('transaction_id_ref')->nullable(); // payment reference number

            $table->timestamps();

            // Foreign keys
            $table->foreign('transaction_id')->references('id')->on('salary_transactions')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_payments');
    }
}
