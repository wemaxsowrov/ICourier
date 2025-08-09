<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_online_payments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('payment_type')->nullable();
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('merchant_id')->nullable()->constrained('merchants')->onUpdate('cascade')->onDelete('cascade');
            $table->string('transaction_id')->nullable();
            $table->decimal('amount',16,2)->nullable();
            $table->string('note')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->index('merchant_id');
            $table->index('account_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_online_payments');
    }
};
