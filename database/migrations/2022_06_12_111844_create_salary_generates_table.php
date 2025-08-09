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
        Schema::create('salary_generates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('month')->nullable();
            $table->decimal('amount',16,2)->default(0);
            $table->unsignedBigInteger('status')->default(0)->comment('Unpaid=0,Paid=1,Partial Paid=2');
            $table->decimal('due',16,2)->default(0);
            $table->decimal('advance',16,2)->default(0); 
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('month');
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
        Schema::dropIfExists('salary_generates');
    }
};
